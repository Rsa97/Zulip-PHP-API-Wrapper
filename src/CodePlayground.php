<?php

namespace Rsa97\Zulip;

class CodePlayground implements \JsonSerializable
{
    use Jsonable;

    #[Jsonable('name')]
    public readonly string $name;
    #[Jsonable('pygments_language')]
    public readonly string $pygmentLanguage;
    #[Jsonable('url_prefix')]
    public readonly string $urlPrefix;

    public function __construct(string $name, string $pygmentLanguage, string $urlPrefix)
    {
        $this->name = $name;
        $this->pygmentLanguage = $pygmentLanguage;
        $this->urlPrefix = $urlPrefix;
    }
}
