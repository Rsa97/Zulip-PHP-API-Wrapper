<?php

namespace Rsa97\Zulip;

enum AnchorType: string
{
    case NEWEST = 'newest';
    case OLDEST = 'oldest';
    case FIRST_UNREAD = 'first_unread';
}
