<?php

namespace Rsa97\Zulip;

class Presence
{
    use Parseable;
    
    #[Parseable('status', type: 'class', class: 'PresenceStatus')]
    public readonly PresenceStatus $status;
    #[Parseable('timestamp', type: 'timestamp')]
    public readonly \DateTimeImmutable $timestamp;
}
