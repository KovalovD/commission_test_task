<?php

declare(strict_types=1);

namespace App\CommissionTask\Enums;

enum Currency: string
{
    public const Currency DEFAULT_CURRENCY = self::EUR;

    case USD = 'USD';
    case EUR = 'EUR';
    case JPY = 'JPY';

    public static function getValues(): string
    {
        $values = '';

        foreach (self::cases() as $case) {
            $values .= $case->value.',';
        }

        return $values;
    }

    public function getRounds(): int
    {
        return match ($this) {
            self::EUR, self::USD => 2,
            self::JPY => 0
        };
    }
}
