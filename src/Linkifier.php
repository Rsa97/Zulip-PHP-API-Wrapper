<?php

namespace Rsa97\Zulip;

use JsonSerializable;

class Linkifier implements JsonSerializable
{
    use Parseable;
    use Jsonable;

    #[Parseable('id')]
    public readonly int $id;
    #[Parseable('url_format', required: true)]
    #[Jsonable('url_format_string')]
    public readonly string $urlFormat;
    #[Parseable('pattern', required: true)]
    #[Jsonable('pattern')]
    public readonly string $pattern;

    public function __construct(string $pattern, string $urlFormat)
    {
        $this->pattern = $pattern;
        $this->urlFormat = $urlFormat;
    }
}
