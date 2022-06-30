<?php

namespace Rsa97\Zulip;

trait Parseable
{
    public static function from(object $source): static
    {
        $result = [
            'required' => [],
            'optional' => []
        ];
        $class = get_class();
        $ref = new \ReflectionClass($class);
        $nameSpace = $ref->getNamespaceName();
        foreach($ref->getProperties() as $prop) {
        	$name = $prop->name;
        	foreach ($prop->getAttributes() as $attr) {
        		if ($attr->getName() === __TRAIT__) {
        			$args = $attr->getArguments();
        			$objName = $args[0] ?? null;
                    $propType = ($args['required'] ?? false) ? 'required' : 'optional';
        			if ($objName !== null && isset($source->{$objName})) {
        				$val = $source->{$objName};
        				switch ($args['type'] ?? null) {
        					case 'timezone':
                                if ($val !== '') {
        						    $result[$propType][$name] = new \DateTimeZone($val);
                                }
        						break;
                            case 'timestamp_ms':
                                $val /= 1000;
                            case 'timestamp':
                                $result[$propType][$name] = (new \DateTimeImmutable())->setTimestamp($val);
                                break;
                            case 'class':
        						$result[$propType][$name] = "{$nameSpace}\\{$args['class']}"::from($val);
        						break;
                            case 'array':
                                $result[$propType][$name] = array_map(
                                    fn($el) => "{$nameSpace}\\{$args['class']}"::from($el),
                                    $val
                                );
                                break;
                            case 'method':
                                $method = $args['method'];
                                $result[$propType][$name] = static::$method($val);
                                break;
        					default:
        						$result[$propType][$name] = $val;
        						break;
        				}
        			} elseif ($objName === null) {
                        switch ($args['type'] ?? null) {
                            case 'class':
                                $result[$propType][$name] = "{$nameSpace}\\{$args['class']}"::from($source);
                                break;
                            case 'method':
                                $method = $args['method'];
                                $result[$propType][$name] = static::$method($source);
                                break;
                        }
                    }
        		}
        	}
        }
        $ths = new static(...$result['required']);
        foreach ($result['optional'] as $name => $value) {
            $ths->{$name} = $value;
        }
        return $ths;
    }
}