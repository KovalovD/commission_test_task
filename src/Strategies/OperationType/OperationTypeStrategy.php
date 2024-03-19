<?php

declare(strict_types=1);

namespace App\CommissionTask\Strategies\OperationType;

use App\CommissionTask\Models\Operation;
use App\CommissionTask\ValueObjects\Money;

interface OperationTypeStrategy
{
    public function handle(Operation $operation): Money;
}
