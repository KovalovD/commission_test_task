<?php

declare(strict_types=1);

namespace App\CommissionTask\ValueObjects;

use App\CommissionTask\Enums\Currency;
use App\CommissionTask\Services\ExchangeRatesApi;

class Money
{
    public function __construct(
        private float $amount = 0,
        private readonly Currency $currency = Currency::DEFAULT_CURRENCY
    ) {
    }

    /**
     * @throws \JsonException
     */
    public static function exchange(Money $money, Currency $exchangeTo): Money
    {
        if ($money->getCurrency() === Currency::DEFAULT_CURRENCY) {
            $newCurrency = $exchangeTo;
            $newValue = $money->getAmount() * ExchangeRatesApi::getRate($exchangeTo);
        } else {
            $newCurrency = $money->getCurrency();
            $newValue = $money->getAmount() / ExchangeRatesApi::getRate($money->getCurrency());
        }

        return new Money($newValue, $newCurrency);
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function add(Money $money): void
    {
        $this->amount += $money->getAmount();
    }

    public function ceil(): self
    {
        $multiplier = 10 ** $this->getCurrency()->getRounds();
        $this->amount = ceil($this->amount * $multiplier) / $multiplier;

        return $this;
    }
}
