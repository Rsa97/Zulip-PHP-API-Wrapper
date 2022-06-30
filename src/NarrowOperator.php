<?php

namespace Rsa97\Zulip;

enum NarrowOperator: string
{
    case SEARCH = 'search';
    case STREAM = 'stream';
    case TOPIC = 'topic';
    case IS = 'is';
    case HAS = 'has';
    case PM_WITH = 'pm-with';
    case SENDER = 'sender';
    case NEAR = 'near';
    case ID = 'id';
    case GROUP_PM_WITH = 'group-pm-with';
}
