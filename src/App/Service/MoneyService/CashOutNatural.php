<?php

declare(strict_types=1);

namespace App\Service\MoneyService;

use App\Models\Money;
use App\Models\Transaction;

class CashOutNatural
{
    private static $commissionRate = 0.003;
    private static $weeklyAmount = 1000;
    private static $weeklyTimes = 3;

    public function calculate(Transaction $transaction): Money
    {
        $weekly = new Money(
            CashOutNatural::$weeklyAmount,
            'EUR'
        );
        $convertedTransaction = CurrencyConverter::convert(
            $transaction->getMoney(),
            'EUR'
        );
        $activeAmount = $weekly;
        $transactionEUR = CurrencyConverter::convert(
            $transaction->getMoney(),
            'EUR'
        );
        $amount = $transaction->getAmount();
        if ($transactionEUR->getAmount()
            <= $weekly->getAmount() - $transaction->getWeeklyEUR()
            && $transaction->getWeeklyTimes() < CashOutNatural::$weeklyTimes) {
            return new money(0, 'EUR');
        } elseif ($transactionEUR->getAmount()
            > $weekly->getAmount() - $transaction->getWeeklyEUR()
            && $transaction->getWeeklyTimes() < CashOutNatural::$weeklyTimes) {
            $discount =
                    $transaction->getWeeklyEUR()
                    - CashOutNatural::$weeklyAmount;
            if ($discount > 0) {
                $discount = 0;
            }
            $transactionEUR->setAmount(
                $transactionEUR->getAmount() + $discount
            );
        } else {
        }
        $activeTransaction = CurrencyConverter::convert(
            $transactionEUR, $transaction->getCurrency());
        $commission = new Money(
            $activeTransaction->getAmount() * CashOutNatural::$commissionRate,
            $activeTransaction->getCurrency()
        );

        return $commission;
    }
}
