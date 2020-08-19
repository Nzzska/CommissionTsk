<?php

require_once 'vendor\autoload.php';

use App\Models\Transaction;

use App\Service\DataService\DataReader;

use App\Service\DataService\WeekChecker;

use App\Service\DataService\InputValidator;

use App\Service\MoneyService\CommissionCalculator;

use App\Service\MoneyService\CurrencyRounder;

use App\Service\MoneyService\CurrencyConverter;

use App\Controllers\CalculationsController;

use App\Controllers\HistoryController;

$filename = $argv[1];
$transactionArray = DataReader::readDataFromCSV($filename);
if ($transactionArray[0] === 'Error encountered on line '
    || $transactionArray[0] === 'Invalid input on line ') {
    exit;
}
$transactionArray = HistoryController::assignHistory($transactionArray);
foreach ($transactionArray as $transaction) {
    $commission = CalculationsController::calculateCommission($transaction);
    CurrencyRounder::roundCurrency($commission);
    $commissionAmount = $commission->getAmount();
    echo $commissionAmount . "\n";
}
