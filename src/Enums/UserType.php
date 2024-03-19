<?php

declare(strict_types=1);

namespace App\CommissionTask\Enums;

enum UserType: string
{
    case PRIVATE = 'private';
    case BUSINESS = 'business';
}
