<?php

namespace Rsa97\Zulip;

class ExternalAuthenticationMethod
{
    use Parseable;

    #[Parseable('name')]
    public readonly string $name;
    #[Parseable('display_name')]
    public readonly string $displayName;
    #[Parseable('display_icon')]
    public readonly ?string $displayIcon;
    #[Parseable('login_url')]
    public readonly string $loginUrl;
    #[Parseable('signup_url')]
    public readonly string $sugnupUrl;
}
