<?php

namespace Rsa97\Zulip;

class Subscription
{
    use Parseable;

    #[Parseable('subscribers')]
    public readonly array $subscriberIds;
    #[Parseable('desktop_notifications')]
    public readonly bool $desktopNotification;
    #[Parseable('email_notifications')]
    public readonly bool $emailNotification;
    #[Parseable('wildcard_mentions_notify')]
    public readonly bool $wildcardMentionNotify;
    #[Parseable('push_notifications')]
    public readonly bool $pushNotification;
    #[Parseable('audible_notifications')]
    public readonly bool $audibleNotification;
    #[Parseable('pin_to_top')]
    public readonly bool $pinToTop;
    #[Parseable('email_address')]
    public readonly string $emailAddress;
    #[Parseable('is_muted')]
    public readonly bool $isMuted;
    #[Parseable('role', type: 'class', class: 'StreamRole')]
    public readonly StreamRole $role;
    #[Parseable('color')]
    public readonly string $color;
    #[Parseable('stream_weekly_traffic')]
    public readonly int $weeklyTraffic;
    #[Parseable(null, type: 'class', class: 'Stream')]
    public readonly Stream $stream;
}
