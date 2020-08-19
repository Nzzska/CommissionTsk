<?php

declare(strict_types=1);

namespace App\Service\MoneyService;

use App\Models\Money;

class CurrencyConverter
{
    public static function convert(
        Money $amountCurrency,
        string $destinationCurrency
        ): Money {
        $startingAmount = $amountCurrency->getAmount();
        $startingRate = Money::getRate($amountCurrency->getCurrency());
        $destinationRate = Money::getRate($destinationCurrency);
        $convertedAmount = $startingAmount / $startingRate * $destinationRate;
        $returnAmountCurrency = new Money(
            $convertedAmount,
            $destinationCurrency
        );

        return $returnAmountCurrency;
    }
}
