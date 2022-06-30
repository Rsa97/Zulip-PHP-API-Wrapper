<?php

namespace Rsa97\Zulip;

class StreamRecipient extends Recipient
{
    use Parseable;
    use Jsonable;

    #[Parseable('to', required: true, type: 'method', method: 'parseStreamId')]
    #[Parseable('stream_id', required: true)]
    #[Jsonable('to', type: 'method', method: 'jsonTo')]
    public readonly int|string $streamId;
    #[Parseable('topic', required: true)]
    #[Parseable('subject', required: true)]
    #[Jsonable('topic')]
    public readonly string $topic;
    #[Jsonable('type', type: 'enum')]
    public readonly RecipientType $type;

    public function __construct(int|string $streamId, string $topic)
    {
        $this->streamId = $streamId;
        $this->topic = $topic;
        $this->type = RecipientType::STREAM;
    }

    protected static function parseStreamId(array $to): int
    {
        return $to[0];
    }

    protected function jsonTo(): array
    {
        return [$this->streamId];
    }
}
