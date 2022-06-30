<?php

namespace Rsa97\Zulip;

enum BotType: int
{
    case GENERIC = 1;
    case INCOMING_WEBHOOK = 2;
    case OUTGOING_WEBHOOK = 3;
    case EMBEDDED = 4;
}
