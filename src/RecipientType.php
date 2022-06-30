<?php

namespace Rsa97\Zulip;

enum RecipientType: string
{
    case STREAM = 'stream';
    case PRIVATE = 'private';
}
