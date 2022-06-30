<?php

namespace Rsa97\Zulip;

enum NarrowIsOperand: string
{
    case PRIVATE = 'private';
    case ALTERED = 'alerted';
    case MENTIONED = 'mentioned';
    case STARRED = 'starred';
    case RESOLVED = 'resolved';
    case UNREAD = 'unread';
}
