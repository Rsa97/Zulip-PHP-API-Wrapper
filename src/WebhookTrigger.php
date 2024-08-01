<?php

namespace Rsa97\Zulip;

enum WebhookTrigger: string
{
    case PRIVATE = 'direct_message';
    case MENTION = 'mention';
}
