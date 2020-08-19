<?php

declare(strict_types=1);

namespace App\Models;

class CurrencyGatherer
//this is where I assume we'd add database or API calls.
{
    public static function getSupportedCurrencies(): array
    {
        return ['EUR', 'USD', 'JPY'];
    }

    public static function getRate($currency): float
    {
        $rates = [
            'EUR' => 1.0,
            'USD' => 1.1497,
            'JPY' => 129.53,
        ];

        return $rates[$currency];
    }

    public static function getCentsStatus($currency): bool
    {
        $hasCents = [
            'EUR' => true,
            'USD' => true,
            'JPY' => false,
        ];

        return $hasCents[$currency];
    }
}
