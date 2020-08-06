<?php

declare(strict_types=1);

namespace App\Service\DataService;

use App\Service\MoneyService\CurrencyConverter;
use DateTimeImmutable;

class WeeklyAssigner
{
    public static function assignWeeklyAmounts(array $transactionArray): array
    {   /** we create second array (which starts empty) so we can store
        *   transactions which we already processed.
        *   we will itterate over both arrays, so we can check all
        *   pairs of dates, to see if any of them were on the same
        *   week.
        */
        $processedTransactionArray = [];
        foreach ($transactionArray as $transaction) {
            $dateTransaction = $transaction->getDate();
            foreach ($processedTransactionArray as $processed) {
                $dateProcessed = $processed->getDate();
                /** we create new money object,  which is equal to
                 * amount of one of the previous transactions
                 * because we keep accounting weekly withdrawals in EUR
                 * inside the system.
                 * (currency converter is creating new object.).
                 */
                $weeklyDeduction = CurrencyConverter::convertCurrency(
                    $processed->getMoney(),
                    'EUR'
                );
                /**checking if 2 transactions are on the same week, same id,
                 * both cash_out
                 */
                if ($processed->getOperationType() === 'cash_out'
                    && $transaction->getId() === $processed->getId()
                    && WeeklyAssigner::isSameWeek(
                    $dateTransaction, $dateProcessed) === true) {
                    $transaction->deductFreeWithdrawals(
                        $weeklyDeduction->getAmount(),
                        1
                    );
                }
            }
            array_push($processedTransactionArray, $transaction);
        }

        return $processedTransactionArray;
    }

    private static function isSameWeek(
        DateTimeImmutable $date1,
        DateTimeImmutable $date2
        ): bool {
        $daysToCheck = $date1->format('N');
        $difference = $date1->diff($date2);
        if ($difference->format('%d') < $daysToCheck) {
            return true;
        } else {
            return false;
        }
    }
}
