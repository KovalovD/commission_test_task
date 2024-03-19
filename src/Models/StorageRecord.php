<?php

declare(strict_types=1);

namespace App\CommissionTask\Models;

use App\CommissionTask\Enums\Currency;
use App\CommissionTask\ValueObjects\Money;

class StorageRecord
{
    public function __construct(
        private array $operations = [],
        private Money $totalMoney = new Money()
    ) {
    }

    /**
     * @throws \JsonException
     */
    public function pushOperation(Operation $operation): self
    {
        $this->operations[] = $operation;
        $this->reCalculateAmount();

        return $this;
    }

    /**
     * @throws \JsonException
     */
    private function reCalculateAmount(): void
    {
        $newAmount = new Money();

        /** @var Operation $operation */
        foreach ($this->operations as $operation) {
            $newAmount->add(Money::exchange($operation->getMoney(), Currency::EUR));
        }

        $this->totalMoney = $newAmount;
    }

    public function getTotalMoney(): Money
    {
        return $this->totalMoney;
    }

    public function getOperations(): array
    {
        ksort($this->operations);

        return $this->operations;
    }
}
