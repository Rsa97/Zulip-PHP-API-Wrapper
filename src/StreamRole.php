<?php

namespace Rsa97\Zulip;

enum StreamRole: int
{
    case ADMINISTRATOR = 20;
    case SUBSCRIBER = 50;
}
