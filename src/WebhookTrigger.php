<?php

namespace Rsa97\Zulip;

enum WebhookTrigger: string
{
    case PRIVATE = 'private_message';
    case MENTION = 'mention';
}
