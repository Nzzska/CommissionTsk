<?php

require_once 'vendor\autoload.php';

use App\Service\DataService\DataReader;
use App\Service\DataService\InputValidator;
use App\Service\MoneyService\CurrencyRounder;
use App\Controllers\CalculationsController;
use App\Controllers\HistoryController;

$filename = $argv[1];
$transactionArray = DataReader::readDataFromCSV($filename);
if ($transactionArray !== NULL) {
    $transactionArray = HistoryController::assignHistory($transactionArray);
    foreach ($transactionArray as $transaction) {
        $commission = CalculationsController::calculateCommission($transaction);
        CurrencyRounder::roundCurrency($commission);
        $commissionAmount = $commission->getAmount();
        echo $commissionAmount . "\n";
    }
}