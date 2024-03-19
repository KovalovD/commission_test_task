<?php

declare(strict_types=1);

namespace App\CommissionTask\Enums;

enum OperationType: string
{
    case WITHDRAW = 'withdraw';
    case DEPOSIT = 'deposit';
}
