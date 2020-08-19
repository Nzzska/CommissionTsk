<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Money;
use App\Models\Transaction;
use App\Service\MoneyService\CashInLegal;
use App\Service\MoneyService\CashInNatural;
use App\Service\MoneyService\CashOutLegal;
use App\Service\MoneyService\CashOutNatural;

class CalculationsController
{
    public static function CalculateCommission(Transaction $transaction): Money
    {
        if ($transaction->getOperationType() === 'cash_in') {
            if ($transaction->getLegalStatus() === 'legal') {
                return CashInLegal::calculate($transaction);
            } elseif ($transaction->getLegalStatus() === 'natural') {
                return CashInNatural::calculate($transaction);
            }
        } elseif ($transaction->getOperationType() === 'cash_out') {
            if ($transaction->getLegalStatus() === 'legal') {
                return CashOutLegal::calculate($transaction);
            } elseif ($transaction->getLegalStatus() === 'natural') {
                return CashOutNatural::calculate($transaction);
            }
        }
    }
}
