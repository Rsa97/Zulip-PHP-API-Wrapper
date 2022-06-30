<?php

namespace Rsa97\Zulip;

enum EditPropagateMode: string
{
    case ONE = 'change_one';
    case LATER = 'change_later';
    case ALL = 'change_all';
}
