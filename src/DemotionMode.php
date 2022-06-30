<?php

namespace Rsa97\Zulip;

enum DemotionMode: int
{
    case AUTO = 1;
    case ALWAYS = 2;
    case NEVER = 3;
}
