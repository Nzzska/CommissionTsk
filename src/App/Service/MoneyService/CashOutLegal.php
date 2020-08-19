<?php

declare(strict_types=1);

namespace App\Service\MoneyService;

use App\Models\Money;
use App\Models\Transaction;

class CashOutLegal
{
    private static $minCommission = 0.5;
    private static $commissionRate = 0.003;

    public function calculate(Transaction $transaction): Money
    {
        $min = new Money(CashOutLegal::$minCommission, 'EUR');
        $commission = new Money(
            $transaction->getAmount() * CashOutLegal::$commissionRate,
            $transaction->getCurrency()
        );
        $convertedCommission = CurrencyConverter::convert($commission, 'EUR');
        if (
            $convertedCommission->getAmount()
            < $min->getAmount()) {
            return CurrencyConverter::convert($min, $transaction->getCurrency());
        } else {
            return $commission;
        }
    }
}
