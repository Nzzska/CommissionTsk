<?php

declare(strict_types=1);

namespace App\Service\DataService;

use App\Models\Transaction;
use App\Service\MoneyService\CurrencyConverter;
use DateTimeImmutable;

class WeekChecker
{
    public static function assignSameWeeks(
        Transaction $transaction1, Transaction $transaction2): void
    {
        $date1 = $transaction1->getDate();
        $date2 = $transaction2->getDate();
        $id1 = $transaction1->getId();
        $id2 = $transaction2->getId();
        $operationType1 = $transaction1->getOperationType();
        $operationType2 = $transaction2->getOperationType();
        $sumToAdd = CurrencyConverter::convert(
            $transaction2->getMoney(),
            'EUR'
        );
        if (WeekChecker::isSameWeek($date1, $date2) === true
            && $id1 === $id2
            && $operationType1 === $operationType2) {
            $transaction1->addThisWeek(
                    $sumToAdd->getAmount(),
                    1
                );
        }
    }

    public static function isSameWeek(
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
