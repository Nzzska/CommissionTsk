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
                $id = $words[1];
                $legalStatus = $words[2];
                $operationType = $words[3];
                $amount = $words[4];
                $currency = $words[5];
                $validity = InputValidator::validateTransaction(
                    $date,
                    $id,
                    $legalStatus,
                    $operationType,
                    $amount,
                    $currency
                );
                if ($validity === false) {
                    $errorMessage = [
                        'Invalid input on line ',
                        $lineCount,
                    ];
                    echo $errorMessage[0].$errorMessage[1];

                    return $errorMessage;
                }
                $date = new DateTimeImmutable($date);
                $amount = (float) $amount;
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
            echo $errorMessage[0].$errorMessage[1];

            return $errorMessage;
            throw $e;
        }

        return $transactionArray;
    }
}
