<?php

namespace App\Domain\Constants;

enum RoleEnum: string
{
    case SUPERUSER = 'superuser';
    case ADMIN = 'admin';
    case ATHLETE = 'athlete';
}
