<?php

namespace Rsa97\Zulip;

class Attachment
{
    use Parseable;

    #[Parseable('id')]
    public readonly int $id;
    #[Parseable('name')]
    public readonly string $name;
    #[Parseable('path_id')]
    public readonly string $path;
    #[Parseable('size')]
    public readonly int $size;
    #[Parseable('create_time', type: 'timestamp_ms')]
    public readonly \DateTimeImmutable $created;
    #[Parseable('messages', type: 'array', class: 'AttachmentMessageInfo')]
    public readonly array $messages;
}
