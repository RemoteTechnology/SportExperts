<?php

namespace App\Domain\Constants\EnumConstants;

enum ResponseTypeEnum: string
{
    case DataResponse = 'DataResponse';
    case DataEmptyResponse = 'DataEmptyResponse';
    case MessageSuccessResponse = 'MessageSuccessResponse';
    case MessageErrorResponse = 'MessageErrorResponse';
}
