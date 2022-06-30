<?php

namespace Rsa97\Zulip;

class StreamSubscriptionProperty implements \JsonSerializable
{
    use Jsonable;

    #[Jsonable('stream_id')]
    public readonly int $streamId;
    #[Jsonable('property', 'enum')]
    public readonly SubscriptionProperty $property;
    #[Jsonable('value')]
    public readonly string|bool $value;

    public function __construct(int $streamId, SubscriptionProperty $property, string|bool $value)
    {
        $this->streamId = $streamId;
        $this->property = $property;
        $this->value = $value;
    }
}
