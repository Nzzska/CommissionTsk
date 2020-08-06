<?php

declare(strict_types=1);

namespace App\Service\MoneyService;

use App\Models\Money;
use App\Models\Transaction;

class CommissionCalculator
{
    private static $cashInCommissionRate = 0.0003;
    private static $maxCashInCommission = 5.0;
    private static $cashOutCommissionRate = 0.003;
    private static $minCashOutCommission = 0.5;

    public static function calculateCommission(Transaction $transaction): Money
    {
        $amountCurrency = $transaction->getMoney();
        $legalStatus = $transaction->getLegalStatus();
        $operationType = $transaction->getOperationType();
        $weeklyEUR = $transaction->getWeeklyAmountEUR();
        $weeklyTimes = $transaction->getWeeklyAmountTimes();
        // finalCommission is a Money object we'll be outputting,
        // right now just declaring it in this scope.
        $finalCommission = $amountCurrency;
        if ($operationType === 'cash_in') {
            $commission = new Money(
                $amountCurrency->getAmount()
                * CommissionCalculator::$cashInCommissionRate,
                $amountCurrency->getCurrency()
            );
            $finalCommission = CommissionCalculator::applyMAX(
                $commission,
                CommissionCalculator::$maxCashInCommission
            );
        } elseif ($operationType === 'cash_out') {
            if ($legalStatus === 'legal') {
                $commission = new Money(
                    $amountCurrency->getAmount()
                    * CommissionCalculator::$cashOutCommissionRate,
                    $amountCurrency->getCurrency()
                );
                $finalCommission = CommissionCalculator::applyMIN(
                    $commission,
                    CommissionCalculator::$minCashOutCommission
                );
            } else {
                $commission = CommissionCalculator::deductWeeklyAmount(
                    $weeklyTimes,
                    $weeklyEUR,
                    $amountCurrency
                );
                $finalCommission = new Money(
                $commission->getAmount()
                * CommissionCalculator::$cashOutCommissionRate,
                $commission->getCurrency()
                );
            }
        }

        return $finalCommission;
    }

    //this method applies maximum, if commission exceeds max,
    //this will return max converted in desired currency
    //otherwise returns just commission.
    private static function applyMAX(
        Money $amountCurrency,
        float $max
        ): Money {
        $amountEUR = CurrencyConverter::convertCurrency(
            $amountCurrency,
            'EUR'
        );
        if ($amountEUR->getAmount() >= $max) {
            $amountEUR->setAmount($max);

            return CurrencyConverter::convertCurrency(
                $amountEUR,
                $amountCurrency->getCurrency()
            );
        } else {
            return $amountCurrency;
        }
    }

    //very similar to appymax, just min.
    private static function applyMIN(
        Money $amountCurrency,
        float $min
        ): Money {
        $amountEUR = CurrencyConverter::convertCurrency(
            $amountCurrency,
            'EUR'
        );
        if ($amountEUR->getAmount() <= $min) {
            $amountEUR->setAmount($min);

            return CurrencyConverter::convertCurrency(
                $amountEUR,
                $amountCurrency->getCurrency()
            );
        } else {
            return $amountCurrency;
        }
    }

    //This function detucts amount we
    //can cash out for free from our amount.
    private static function deductWeeklyAmount(
        int $WeeklyTimes,
        float $WeeklyEUR,
        Money $amountCurrency
        ): Money {
        $amountEUR = CurrencyConverter::convertCurrency(
            $amountCurrency,
            'EUR'
        );
        $finalAmount = $amountEUR;
        if ($amountEUR->getAmount() <= $WeeklyEUR
            && $WeeklyTimes > 0) {
            $finalAmount->setAmount(0);
        } elseif ($amountEUR->getAmount() > $WeeklyEUR
            && $WeeklyTimes > 0) {
            $finalAmount->setAmount($amountEUR->getAmount() - $WeeklyEUR);
        }

        return CurrencyConverter::convertCurrency(
            $finalAmount, $amountCurrency->getCurrency());
    }
}
