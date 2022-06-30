<?php

namespace Rsa97\Zulip;

class Matches
{
    use Parseable;

    #[Parseable('match_content')]
    public readonly string $content;
    #[Parseable('match_subject')]
    public readonly string $subject;
}
