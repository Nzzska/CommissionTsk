<?php

require_once 'src/App/start.php';

use App\Models\Transaction;

use App\Service\DataService\DataReader;

use App\Service\DataService\WeeklyAssigner;

use App\Service\DataService\InputValidator;

use App\Service\MoneyService\CommissionCalculator;

use App\Service\MoneyService\CurrencyRounder;

use App\Service\MoneyService\CurrencyConverter;

$filename = $argv[1];
$transactionArray = DataReader::readDataFromCSV($filename);
if ($transactionArray[0] === 'Error encountered on line ') {
    exit;
}
$transactionArray = WeeklyAssigner::assignWeeklyAmounts($transactionArray);
foreach ($transactionArray as $transaction) {
    $commission = CommissionCalculator::calculateCommission($transaction);
    $roundedCommission = 
    CurrencyRounder::RoundCurrency($commission);
    $commissionAmount = $commission->getAmount();
    echo $commissionAmount . "\n";
}
