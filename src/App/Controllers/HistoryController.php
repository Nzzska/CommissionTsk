<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Service\DataService\WeekChecker;

class HistoryController
{
    public static function assignHistory(array $transactionArray): array
    {
        $processedTransactionArray = [];
        foreach ($transactionArray as $transaction) {
            foreach ($processedTransactionArray as $processed) {
                // here it's possible to add more functions (for example)
                // to keep how much money was withdrawn this month etc.
                WeekChecker::assignSameWeeks($transaction, $processed);
            }
            array_push($processedTransactionArray, $transaction);
        }

        return $processedTransactionArray;
    }
}
