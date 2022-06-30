<?php

namespace Rsa97\Zulip;

class AttachmentMessageInfo
{
    use Parseable;

    #[Parseable('id')]
    public readonly int $id;
    #[Parseable('date_sent', type: 'timestamp_ms')]
    public readonly \DateTimeImmutable $dateSent;
}
