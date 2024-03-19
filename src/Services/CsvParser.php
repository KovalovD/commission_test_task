<?php

declare(strict_types=1);

namespace App\CommissionTask\Services;

use App\CommissionTask\Enums\Currency;
use App\CommissionTask\Enums\OperationType;
use App\CommissionTask\Enums\UserType;
use App\CommissionTask\Models\Operation;
use App\CommissionTask\ValueObjects\Money;

class CsvParser
{
    private array $operations;

    public function __construct(private readonly string $filePath)
    {
    }

    /**
     * @throws \Exception
     */
    public function parse(): array
    {
        if (($handle = fopen($this->filePath, 'rb')) !== false) {
            while (($row = fgetcsv($handle, 1000)) !== false) {
                $date = new \DateTime($row[0]);
                $this->operations[] = new Operation(
                    $date,
                    (int) $row[1],
                    UserType::from($row[2]),
                    OperationType::from($row[3]),
                    new Money((float) $row[4], Currency::from($row[5])));
            }
            fclose($handle);
        }

        return $this->operations;
    }
}
