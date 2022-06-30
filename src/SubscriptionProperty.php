<?php

namespace Rsa97\Zulip;

enum SubscriptionProperty: string
{
    case COLOR = 'color';
    case IS_MUTED = 'is_muted';
    case PIN_TO_TOP = 'pin_to_top';
    case DESKTOP_NOTIFICATIONS = 'desktop_notifications';
    case AUDIBLE_NOTIFICATIONS = 'audible_notifications';
    case PUSH_NOTIFICATIONS = 'push_notifications';
    case EMAIL_NOTIFICATIONS = 'email_notifications';
    case WILDCARD_MENTIONS_NOTIFY = 'wildcard_mentions_notify';
}
