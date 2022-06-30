<?php

namespace Rsa97\Zulip;

class CustomEmoji
{
    use Parseable;

    #[Parseable('id')]
    public readonly int $id;
    #[Parseable('name')]
    public readonly string $name;
    #[Parseable('source_url')]
    public readonly string $sourceUrl;
    #[Parseable('still_url')]
    public readonly ?string $stillUrl;
    #[Parseable('deactivated')]
    public readonly bool $deactivated;
    #[Parseable('author_id')]
    public readonly ?int $authorId;
}
