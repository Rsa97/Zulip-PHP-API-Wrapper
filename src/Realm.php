<?php

namespace Rsa97\Zulip;

class Realm
{
    use Parseable;

    #[Parseable('realm_uri')]
    public readonly string $uri;
    #[Parseable('realm_name')]
    public readonly string $name;
    #[Parseable('realm_icon')]
    public readonly string $icon;
    #[Parseable('realm_description')]
    public readonly string $description;
    #[Parseable('realm_web_public_access_enabled')]
    public readonly string $webPublicAccessEnabled;
}