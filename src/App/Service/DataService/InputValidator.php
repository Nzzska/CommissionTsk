<?php

declare(strict_types=1);

namespace App\Service\DataService;

use DateTimeImmutable as DateTimeImmutable;

class InputValidator
{
    private static $validCurrencies = ['EUR', 'USD', 'JPY'];
    private static $validLegalStatus = ['legal', 'natural'];
    private static $validOperationTypes = ['cash_in', 'cash_out'];

    public static function validateTransaction(
     $date,
     $id,
     $legalStatus,
     $operationType,
     $amount,
     $currency
    ): bool {
        return
            InputValidator::validateDate($date)
            && InputValidator::validateId($id)
            && InputValidator::validateOperationType($operationType)
            && InputValidator::validateLegalStatus($legalStatus)
            && InputValidator::validateAmount($amount)
            && InputValidator::validateCurrency($currency)
        ;
    }

    private static function validateDate(string $date, $format = 'Y-m-d'): bool
    {
        $datecheck = DateTimeImmutable::createFromFormat($format, $date);

        return $datecheck && $datecheck->format($format) === $date;
    }

    private static function validateID(string $id): bool
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);

        return $id !== false;
    }

    private static function validateLegalStatus(string $legalStatus): bool
    {
        return in_array(
            $legalStatus,
            InputValidator::$validLegalStatus,
            true
        );
    }

    private static function validateOperationType(string $operationType): bool
    {
        return in_array(
            $operationType,
            InputValidator::$validOperationTypes,
            true
        );
    }

    private static function validateCurrency(string $currency): bool
    {
        return in_array(
            $currency,
            InputValidator::$validCurrencies,
            true);
    }

    private static function validateAmount(string $amount): bool
    {
        return is_numeric($amount) && $amount > 0;
    }
}
