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
        $destinationMoney = new Money(0, $destinationCurrency);
        $startingRate = $amountCurrency->
            getRate(
            $amountCurrency->
            getCurrency()
        );
        $destinationRate = $destinationMoney->getRate();
        $convertedAmount = bcmul(bcdiv(
            $startingAmount, $startingRate), 
            $destinationRate
        );
        $destinationMoney->setAmount($convertedAmount);

        return $destinationMoney;
    }
}
