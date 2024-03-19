<?php

declare(strict_types=1);

namespace App\CommissionTask\Services;

use App\CommissionTask\Enums\OperationType;
use App\CommissionTask\Models\Operation;
use App\CommissionTask\Strategies\OperationType\Deposit\DepositStrategy;
use App\CommissionTask\Strategies\OperationType\OperationTypeService;
use App\CommissionTask\Strategies\OperationType\Withdraw\WithdrawStrategy;

readonly class CommissionService
{
    /**
     * @throws \Exception
     */
    public function calculateFees(string $filePath): array
    {
        $operations = (new CsvParser($filePath))->parse();

        /** @var Operation $operation */
        foreach ($operations as $operation) {
            $strategy = match ($operation->getOperationType()) {
                OperationType::DEPOSIT => new DepositStrategy(),
                OperationType::WITHDRAW => new WithdrawStrategy()
            };

            $operation->setFee(OperationTypeService::handle($strategy, $operation)->ceil());
        }

        return $operations;
    }
}
