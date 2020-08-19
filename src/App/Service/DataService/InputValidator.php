<?php

declare(strict_types=1);

namespace App\Service\DataService;

use App\Controllers\ParamsController;
use DateTimeImmutable as DateTimeImmutable;

class InputValidator
{
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
        $validLegalStatus = ParamsController::getSupportedEntityStatuses();

        return in_array(
            $legalStatus,
            $validLegalStatus,
            true
        );
    }

    private static function validateOperationType(string $operationType): bool
    {
        $validOperationTypes = ParamsController::getSupportedOperationTypes();

        return in_array(
            $operationType,
            $validOperationTypes,
            true
        );
    }

    private static function validateCurrency(string $currency): bool
    {
        $validCurrencies = ParamsController::getSupportedCurrencies();

        return in_array(
            $currency,
            $validCurrencies,
            true);
    }

    private static function validateAmount(string $amount): bool
    {
        return is_numeric($amount) && $amount > 0;
    }
}
