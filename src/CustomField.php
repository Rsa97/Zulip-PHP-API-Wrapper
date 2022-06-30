<?php

namespace Rsa97\Zulip;

class CustomField implements \JsonSerializable
{
    use Parseable;
    use Jsonable;

    #[Parseable('id')]
    public readonly int $id;
    #[Parseable('type', required: true, type: 'class', class: 'FieldType')]
    #[Jsonable('field_type', type: 'enum')]
    public readonly FieldType $type;
    #[Parseable('order')]
    public readonly int $order;
    #[Parseable('name', required: true)]
    #[Jsonable('name')]
    public readonly string $name;
    #[Parseable('hint', required: true)]
    #[Jsonable('hint')]
    public readonly string $hint;
    #[Parseable('field_data', required: true, type: 'method', method: 'parseFieldData')]
    #[Jsonable('field_data')]
    public readonly ?object $fieldData;

    public function __construct(FieldType $type, ?string $name = null, ?string $hint = null, array|object|null $fieldData = null)
    {
        $this->type = $type;
        if (isset($name)) {
            $this->name = $name;
        }
        if (isset($hint)) {
            $this->hint = $hint;
        }
        if (isset($fieldData)) {
            $this->fieldData = (object)$fieldData;
        }
    }

    private static function parseFieldData(string $val): ?object
    {
        return json_decode($val);
    }
}
