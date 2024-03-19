<?php

declare(strict_types=1);

namespace App\CommissionTask\Strategies\OperationType;

use App\CommissionTask\Models\Operation;
use App\CommissionTask\ValueObjects\Money;

readonly class OperationTypeService
{
    public static function handle(OperationTypeStrategy $strategy, Operation $operation): Money
    {
        return $strategy->handle($operation);
    }
}
