<?php

namespace Rsa97\Zulip;

enum StreamNotificationType
{
    case DESKTOP;
    case EMAIL;
    case PUSH;
    case AUDIBLE;
}
