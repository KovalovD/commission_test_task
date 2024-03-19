<?php

declare(strict_types=1);

namespace App\CommissionTask\Strategies\OperationType\Withdraw\UserType;

use App\CommissionTask\Models\CommissionStorage;
use App\CommissionTask\Models\Operation;
use App\CommissionTask\Strategies\OperationType\Withdraw\WithdrawUserTypeStrategy;
use App\CommissionTask\ValueObjects\Money;

class PrivateStrategy implements WithdrawUserTypeStrategy
{
    public const float FREE_AMOUNT_SUM = 1000;
    public const float COEFFICIENT = 0.3;

    /**
     * @throws \JsonException
     */
    public function handle(Operation $operation): Money
    {
        $operationsStorage = CommissionStorage::getFromStorageByOperation($operation);

        if (count($operationsStorage->getOperations()) < 3) {
            $freeAmount = new Money(self::FREE_AMOUNT_SUM - $operationsStorage->getTotalMoney()->getAmount());
            $freeAmount = Money::exchange($freeAmount, $operation->getMoney()->getCurrency());
            $calculationSum = $freeAmount->getAmount() > 0
                ? max($operation->getMoney()->getAmount() - $freeAmount->getAmount(), 0)
                : $operation->getMoney()->getAmount();
        } else {
            $calculationSum = $operation->getMoney()->getAmount();
        }

        CommissionStorage::pushToStorage($operation);

        return new Money($calculationSum * (self::COEFFICIENT / 100), $operation->getMoney()->getCurrency());
    }
}
