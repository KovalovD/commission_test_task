<?php

declare(strict_types=1);

namespace App\CommissionTask\Strategies\OperationType\Withdraw;

use App\CommissionTask\Models\Operation;
use App\CommissionTask\ValueObjects\Money;

interface WithdrawUserTypeStrategy
{
    public function handle(Operation $operation): Money;
}
