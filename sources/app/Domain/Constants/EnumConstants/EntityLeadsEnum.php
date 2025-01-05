<?php

namespace App\Domain\Constants\EnumConstants;

enum EntityLeadsEnum: string
{
    case USER_LEAD = 'user';
    case EVENT_LEAD = 'event';
    case OPTION_LEAD = 'option';
}
