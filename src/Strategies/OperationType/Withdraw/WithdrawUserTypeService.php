<?php

declare(strict_types=1);

namespace App\CommissionTask\Strategies\OperationType\Withdraw;

use App\CommissionTask\Models\Operation;
use App\CommissionTask\ValueObjects\Money;

readonly class WithdrawUserTypeService
{
    public static function handle(WithdrawUserTypeStrategy $strategy, Operation $operation): Money
    {
        return $strategy->handle($operation);
    }
}
