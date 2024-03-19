<?php

declare(strict_types=1);

namespace App\CommissionTask\Models;

use App\CommissionTask\Enums\OperationType;
use App\CommissionTask\Enums\UserType;
use App\CommissionTask\ValueObjects\Money;

class Operation
{
    public function __construct(
        private readonly \DateTime $date,
        private readonly int $userId,
        private readonly UserType $userType,
        private readonly OperationType $operationType,
        private readonly Money $money,
        private Money $fee = new Money()
    ) {
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUserType(): UserType
    {
        return $this->userType;
    }

    public function getOperationType(): OperationType
    {
        return $this->operationType;
    }

    public function getMoney(): Money
    {
        return $this->money;
    }

    public function getFee(): Money
    {
        return $this->fee;
    }

    public function setFee(Money $fee): void
    {
        $this->fee = $fee;
    }
}
