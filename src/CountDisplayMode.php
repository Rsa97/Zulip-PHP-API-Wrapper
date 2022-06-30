<?php

namespace Rsa97\Zulip;

enum CountDisplayMode: int
{
    case ALL_UNREADS = 1;
    case PRIVATE_AND_MENTIONS = 2;
    case NONE = 3;
}
