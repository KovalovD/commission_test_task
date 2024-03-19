<?php

declare(strict_types=1);

namespace App\CommissionTask\Strategies\OperationType\Deposit;

use App\CommissionTask\Models\Operation;
use App\CommissionTask\Strategies\OperationType\OperationTypeStrategy;
use App\CommissionTask\ValueObjects\Money;

class DepositStrategy implements OperationTypeStrategy
{
    public const float COEFFICIENT = 0.03;

    public function handle(Operation $operation): Money
    {
        return new Money($operation->getMoney()->getAmount() * (self::COEFFICIENT / 100),
            $operation->getMoney()->getCurrency());
    }
}
