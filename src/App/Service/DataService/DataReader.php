<?php

declare(strict_types=1);

namespace App\Service\DataService;

use App\Models\Money;
use App\Models\Transaction;
use DateTimeImmutable;
use Exception;

class DataReader
{
    public static function readDataFromCSV(string $filename): array
    {
        $transactionArray = [];
        try {
            $filehandle = fopen($filename, 'r') or die('unable to open file');
            $lineCount = 1;
            while (!feof($filehandle)) {
                $words = explode(',', trim(fgets($filehandle)));
                $date = $words[0];
                if (InputValidator::validateDate($date) === false) {
                    throw new Exception();
                }
                $date = new DateTimeImmutable($date);
                $id = $words[1];
                if (InputValidator::validateID($id) === false) {
                    throw new Exception();
                }
                $legalStatus = $words[2];
                if (InputValidator::validateLegalStatus($legalStatus)
                    === false) {
                    throw new Exception();
                }
                $operationType = $words[3];
                if (InputValidator::validateOperationType($operationType)
                    === false) {
                    throw new Exception();
                }
                $amount = $words[4];
                if (InputValidator::validateAmount($amount) === false) {
                    throw new Exception();
                }
                $amount = floatval($amount);
                $currency = $words[5];
                if (InputValidator::validateCurrency($currency) === false) {
                    throw new Exception();
                }
                $amountCurrency = new Money($amount, $currency);
                $transaction = new Transaction(
                    $date,
                    $id,
                    $legalStatus,
                    $operationType,
                    $amountCurrency
                );
                array_push($transactionArray, $transaction);
                $lineCount = $lineCount + 1;
            }
        } catch (Exception $e) {
            $errorMessage = [
                'Error encountered on line ',
                $lineCount,
            ];
            echo $errorMessage[0].$lineCount;

            return $errorMessage;
            throw $e;
        }

        return $transactionArray;
    }
}
