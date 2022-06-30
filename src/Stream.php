<?php

namespace Rsa97\Zulip;

class Stream implements \JsonSerializable
{
    use Parseable;
    use Jsonable;

    #[Parseable('stream_id')]
    public readonly int $id;
    #[Parseable('name', required: true)]
    #[Jsonable('name')]
    public readonly string $name;
    #[Parseable('description', required: true)]
    #[Jsonable('description')]
    public readonly string $description;
    #[Parseable('date_created', type: 'timestamp')]
    public readonly \DateTimeImmutable $dateCreated;
    #[Parseable('rendered_description')]
    public readonly string $renderedDescription;
    #[Parseable('first_message_id')]
    public readonly int $firstMessageId;
    #[Parseable('is_default')]
    public readonly bool $isDefault;
    #[Parseable(null, type: 'class', class: 'StreamProperties')]
    public readonly StreamProperties $properties;

    public function __construct(string $name, ?string $description = null) {
        $this->name = $name;
        if (isset($description)) {
            $this->description = $description;
        }
    }
}
