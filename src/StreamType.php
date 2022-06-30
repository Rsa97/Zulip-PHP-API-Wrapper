<?php

namespace Rsa97\Zulip;

enum StreamType: string
{
    case PUBLIC = 'include_public';
    case WEB_PUBLIC = 'include_web_public';
    case SUBSCRIBED = 'include_subscribed';
    case ALL_ACTIVE = 'include_all_active';
    case DEFAULT = 'include_default';
    case OWNER_SUBSCRIBED = 'include_owner_subscribed';
}
