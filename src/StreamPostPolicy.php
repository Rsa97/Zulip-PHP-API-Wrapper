<?php

namespace Rsa97\Zulip;

enum StreamPostPolicy: int
{
    case ANY = 1;
    case ADMINISTRATORS = 2;
    case FULL_MEMBERS = 3;
    case MODERATORS = 4;
}
