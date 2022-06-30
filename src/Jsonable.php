<?php

namespace Rsa97\Zulip;

trait Jsonable
{
    public function jsonSerialize(): array
    {
        $result = [];
        $class = get_class();
        $ref = new \ReflectionClass($class);
        // $nameSpace = $ref->getNamespaceName();
        foreach($ref->getProperties() as $prop) {
            $name = $prop->name;
            foreach ($prop->getAttributes() as $attr) {
                if ($attr->getName() === __TRAIT__) {
                    $args = $attr->getArguments();
                    $jsonName = $args[0] ?? null;
                    if (isset($this->{$name})) {
                        $val = $this->{$name};
                        if ($jsonName !== null) {
                            switch ($args['type'] ?? null) {
                                // case 'timezone':
                                //     $result[$objName][$name] = new \DateTimeZone($val);
                                //     break;
                                // case 'timestamp_ms':
                                //     $val /= 1000;
                                // case 'timestamp':
                                //     $result[$propType][$name] = (new \DateTimeImmutable())->setTimestamp($val);
                                //     break;
                                case 'enum':
                                    $result[$jsonName] = $val->value;
                                    break;
                                case 'class':
                                    $result[$jsonName] = $val->jsonSerialize();
                                    break;
                                // case 'array':
                                //     $result[$propType][$name] = array_map(
                                //         fn($el) => "{$nameSpace}\\{$args['class']}"::from($el),
                                //         $val
                                //     );
                                //     break;
                                case 'method':
                                    $method = $args['method'];
                                    $result[$jsonName] = $this->{$method}();
                                    break;
                                default:
                                    $result[$jsonName] = $val;
                                    break;
                            }
                        } else {
                            switch ($args['type'] ?? null) {
                                case 'class':
                                    $result = array_merge($result, $val->jsonSerialize());
                                    break;
                                case 'array':
                                    $data = array_map(
                                        fn($e) => $e->jsonSerialize(),
                                        $val
                                    );
                                    $result = array_merge($result, $data);
                                    break;
                                // case 'method':
                                //     $method = $args['method'];
                                //     $result[$propType][$name] = static::$method($source);
                                //     break;
                            }
                        }
                    }
                }
            }
        }
        return $result;
    }
}
