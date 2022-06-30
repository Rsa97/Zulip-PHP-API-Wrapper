<?php

namespace Rsa97\Zulip;

class UserProfileRecord implements \JsonSerializable
{
    use Parseable;

    #[Parseable('id', required: true)]
    public readonly int $id;
    #[Parseable('value', required: true)]
    public readonly string $value;
    #[Parseable('rendered_value')]
    public readonly ?string $renderedValue;

    public function __construct(int $id, string $value)
    {
        $this->id = $id;
        $this->value = $value;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'value' => $this->value
        ];
    }
}
