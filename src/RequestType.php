<?php

namespace Rsa97\Zulip;

enum RequestType: string
{
    case GET = 'GET';
    case POST = 'POST';
    case PATCH = 'PATCH';
    case DELETE = 'DELETE';
}
