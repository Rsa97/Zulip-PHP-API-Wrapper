<?php

namespace Rsa97\Zulip;

enum MessageFlagOperation: string
{
    case ADD = 'add';
    case REMOVE = 'remove';
}
