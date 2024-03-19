<?php

declare(strict_types=1);

namespace App\CommissionTask\Services;

use App\CommissionTask\Enums\Currency;

class ExchangeRatesApi
{
    public static array $currencies = [];

    public static function setCurrencies(array $currencies): void
    {
        self::$currencies = $currencies;
    }

    /**
     * @throws \JsonException
     */
    public static function getRate(Currency $currency): float
    {
        if (self::$currencies) {
            return self::$currencies[$currency->value] ?? 1;
        }

        $access_key = 'c577c4149007ef2bd72fc1783adaeffd';

        $ch = curl_init(
            sprintf('http://api.exchangeratesapi.io/v1/latest?access_key=%s&base=%s&symbols=%s',
                $access_key,
                Currency::DEFAULT_CURRENCY->value,
                Currency::getValues()
            )
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $json = curl_exec($ch);
        curl_close($ch);

        $exchangeRates = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        foreach ($exchangeRates['rates'] as $curCode => $rate) {
            self::$currencies[$curCode] = (float) $rate;
        }

        return self::$currencies[$currency->value] ?? 1;
    }
}
