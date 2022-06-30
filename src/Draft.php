<?php

namespace Rsa97\Zulip;

class Draft implements \JsonSerializable
{
    use Parseable;
    use Jsonable;

    #[Parseable('id')]
    public readonly ?int $id;
    #[Parseable('content', required: true)]
    #[Jsonable('content')]
    public readonly string $content;
    #[Parseable('timestamp', type: 'timestamp')]
    public readonly \DateTimeImmutable $timestamp;
    #[Parseable(null, required: true, type: 'class', class: 'Recipient')]
    #[Jsonable(null, type: 'class')]
    public readonly Recipient $recipient;

    public function __construct(Recipient $recipient, string $content)
    {
        $this->recipient = $recipient;
        $this->content = $content;
    }
}
