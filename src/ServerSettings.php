<?php

namespace Rsa97\Zulip;

class ServerSettings
{
    use Parseable;

    #[Parseable('authentication_methods')]
    public readonly object $authenticationMethods;
    #[Parseable('external_authentication_methods', type: 'array', class: 'ExternalAuthenticationMethod')]
    public readonly array $externalAuthenticationMethods;
    #[Parseable('zulip_feature_level')]
    public readonly int $zulipFeatureLevel;
    #[Parseable('zulip_version')]
    public readonly string $zulipVersion;
    #[Parseable('zulip_merge_base')]
    public readonly string $zulipMergeBase;
    #[Parseable('push_notifications_enabled')]
    public readonly bool $pushNotificationEnabled;
    #[Parseable('is_incompatible')]
    public readonly bool $isIncompatible;
    #[Parseable('email_auth_enabled')]
    public readonly bool $emailAuthenticationEnabled;
    #[Parseable('require_email_format_usernames')]
    public readonly bool $requireEmailFormatUsername;
    #[Parseable(null, type: 'class', class: 'Realm')]
    public readonly Realm $realm;
}
