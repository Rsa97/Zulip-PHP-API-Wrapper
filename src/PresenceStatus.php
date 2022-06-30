<?php

namespace Rsa97\Zulip;

enum PresenceStatus: string
{
    case ACTIVE = 'active';
    case IDLE = 'idle';
    case OFFLINE = 'offline';
}
