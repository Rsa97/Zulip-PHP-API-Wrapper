<?php

namespace Rsa97\Zulip;

enum View: string
{
    case ALL = 'all_messages';
    case RECENT = 'recent_topics';
}
