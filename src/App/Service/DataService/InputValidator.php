<?php

declare(strict_types=1);

namespace App\Service\DataService;

use DateTimeImmutable as DateTimeImmutable;

class InputValidator
{
    private static $validCurrencies = ['EUR', 'USD', 'JPY'];
    private static $validLegalStatus = ['legal', 'natural'];
    private static $validOperationTypes = ['cash_in', 'cash_out'];

    public static function validateDate(string $date, $format = 'Y-m-d'): bool
    {
        $datecheck = DateTimeImmutable::createFromFormat($format, $date);

        return $datecheck && $datecheck->format($format) === $date;
    }

    public static function validateID(string $id): bool
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);

        return $id !== false;
    }

    public static function validateLegalStatus(string $legalStatus): bool
    {
        return in_array(
            $legalStatus,
            InputValidator::$validLegalStatus,
            true
        );
    }

    public static function validateOperationType(string $operationType): bool
    {
        return in_array(
            $operationType,
            InputValidator::$validOperationTypes,
            true
        );
    }

    public static function validateCurrency(string $currency): bool
    {
        return in_array(
            $currency,
            InputValidator::$validCurrencies,
            true);
    }

    public static function validateAmount(string $amount): bool
    {
        return is_numeric($amount) && $amount > 0;
    }
}
