<?php

declare(strict_types=1);

namespace App\Service\MoneyService;

use App\Models\Money;

class CurrencyRounder
{
    public static function roundCurrency(
        Money $amountCurrency
        ): Money {
        $amount = $amountCurrency->getAmount();
        $centsExist = $amountCurrency->getCentsStatus();
        if ($centsExist === false) {
            $amount = ceil($amount);
        } elseif ($centsExist === true) {
            $amount = ceil($amount * 100) / 100;
        }
        $amountCurrency->setAmount($amount);

        return $amountCurrency;
    }
}
