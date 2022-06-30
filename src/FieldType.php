<?php

namespace Rsa97\Zulip;

enum FieldType: int
{
    case SHORT_TEXT = 1;
    case LONG_TEXT = 2;
    case OPTIONS_LIST = 3;
    case DATE_PICKER = 4;
    case LINK = 5;
    case PERSON_PICKER = 6;
    case EXTERNAL_ACCOUNT = 7;
}
