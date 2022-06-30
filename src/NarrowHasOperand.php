<?php

namespace Rsa97\Zulip;

enum NarrowHasOperand: string
{
    case LINK = 'link';
    case IMAGE = 'image';
    case ATTACHMENT = 'attachment';
}
