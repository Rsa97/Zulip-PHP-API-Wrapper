<?php

namespace Rsa97\Zulip;

enum TypingOperation: string
{
    case START = 'start';
    case STOP = 'stop';
}
