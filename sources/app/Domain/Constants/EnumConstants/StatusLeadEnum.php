<?php

namespace App\Domain\Constants\EnumConstants;

enum StatusLeadEnum: string
{
    case PROCESSED = 'Обработан';
    case NOT_PROCESSED = 'Не обработан';
}
