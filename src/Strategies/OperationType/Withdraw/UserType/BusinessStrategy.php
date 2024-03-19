<?php

declare(strict_types=1);

namespace App\CommissionTask\Strategies\OperationType\Withdraw\UserType;

use App\CommissionTask\Models\Operation;
use App\CommissionTask\Strategies\OperationType\Withdraw\WithdrawUserTypeStrategy;
use App\CommissionTask\ValueObjects\Money;

class BusinessStrategy implements WithdrawUserTypeStrategy
{
    public const float COEFFICIENT = 0.5;

    public function handle(Operation $operation): Money
    {
        return new Money($operation->getMoney()->getAmount() * (self::COEFFICIENT / 100),
            $operation->getMoney()->getCurrency());
    }
}
