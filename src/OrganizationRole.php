<?php

namespace Rsa97\Zulip;

enum OrganizationRole: int
{
    case OWNER = 100;
    case ADMINISTRATOR = 200;
    case MODERATOR = 300;
    case MEMBER = 400;
    case GUEST = 600;
}
