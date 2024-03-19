<?php

declare(strict_types=1);

namespace App\CommissionTask\Strategies\OperationType\Withdraw;

use App\CommissionTask\Enums\UserType;
use App\CommissionTask\Models\Operation;
use App\CommissionTask\Strategies\OperationType\OperationTypeStrategy;
use App\CommissionTask\Strategies\OperationType\Withdraw\UserType\BusinessStrategy;
use App\CommissionTask\Strategies\OperationType\Withdraw\UserType\PrivateStrategy;
use App\CommissionTask\ValueObjects\Money;

class WithdrawStrategy implements OperationTypeStrategy
{
    public function handle(Operation $operation): Money
    {
        $strategy = match ($operation->getUserType()) {
            UserType::BUSINESS => new BusinessStrategy(),
            UserType::PRIVATE => new PrivateStrategy()
        };

        return WithdrawUserTypeService::handle($strategy, $operation);
    }
}
