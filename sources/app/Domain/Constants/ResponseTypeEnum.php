<?php

namespace App\Domain\Constants;

enum ResponseTypeEnum: string
{
    case DataResponse = 'DataResponse';
    case DataEmptyResponse = 'DataEmptyResponse';
    case MessageSuccessResponse = 'MessageSuccessResponse';
    case MessageErrorResponse = 'MessageErrorResponse';
}
