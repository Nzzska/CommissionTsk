<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\CurrencyGatherer;
use App\Models\ParametersGatherer;

class ParamsController
{
    public static function getSupportedCurrencies(): array
    {
        return CurrencyGatherer::getSupportedCurrencies();
    }

    public static function getRate($currency): float
    {
        return CurrencyGatherer::getRate($currency);
    }

    public static function getCentsStatus($currency): bool
    {
        return CurrencyGatherer::getCentsStatus($currency);
    }

    public static function getSupportedOperationTypes(): array
    {
        return ParametersGatherer::getSupportedOperationTypes();
    }

    public static function getSupportedEntityStatuses(): array
    {
        return ParametersGatherer::getSupportedEntityStatuses();
    }
}
