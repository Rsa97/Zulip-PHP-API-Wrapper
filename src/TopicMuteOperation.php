<?php

namespace Rsa97\Zulip;

enum TopicMuteOperation: string
{
    case MUTE = 'add';
    case UNMUTE = 'remove';
}
