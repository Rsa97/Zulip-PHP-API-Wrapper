<?php

namespace Rsa97\Zulip;

abstract class Recipient implements \JsonSerializable
{
    protected function __construct() {}

    public static function from(object $recipient)
    {
        switch (RecipientType::from($recipient->type)) {
            case RecipientType::PRIVATE:
                return PrivateRecipient::from($recipient);
            case RecipientType::STREAM:
                return StreamRecipient::from($recipient);
        }
    }
}
