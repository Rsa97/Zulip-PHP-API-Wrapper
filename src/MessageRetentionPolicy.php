<?php

namespace Rsa97\Zulip;

enum MessageRetentionPolicy: string
{
    case DEFAULT = 'realm_default';
    case UNLIMITED = 'unlimited';
}
