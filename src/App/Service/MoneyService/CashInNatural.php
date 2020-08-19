<?php

declare(strict_types=1);

namespace App\Service\MoneyService;

use App\Models\Money;
use App\Models\Transaction;

class CashInNatural
{
    private static $maxCommission = 5.0;
    private static $commissionRate = 0.0003;

    public function calculate(Transaction $transaction): Money
    {
        $max = new Money(CashInNatural::$maxCommission, 'EUR');
        $commission = new Money(
            $transaction->getAmount() * CashInNatural::$commissionRate,
            $transaction->getCurrency()
        );
        $convertedCommission = CurrencyConverter::convert($commission, 'EUR');
        if (
            $convertedCommission->getAmount()
            >= $max->getAmount()) {
            return CurrencyConverter::convert($max, $transaction->getCurrency());
        } else {
            return $commission;
        }
    }
}
