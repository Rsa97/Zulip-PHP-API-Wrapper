<?php

namespace Rsa97\Zulip;

enum ReactionType: string
{
    case UNICODE = 'unicode_emoji';
    case REALM = 'realm_emoji';
    case EXTRA = 'zulip_extra_emoji';
}
