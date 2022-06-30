<?php

namespace Rsa97\Zulip;

enum MessageFlag: string
{
    case READ = 'read';
    case STARRED = 'starred';
    case COLLAPSED = 'collapsed';
    case MENTIONED = 'mentioned';
    case WILDCARD_MENTIONED = 'wildcard_mentioned';
    case HAS_ALERT_WORD = 'has_alert_word';
    case HISTORICAL = 'historical';
}
