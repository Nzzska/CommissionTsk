<?php

declare(strict_types=1);

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Models\Transaction;
use App\Models\Money;
use DateTimeImmutable;

class TransactionTest extends TestCase
{
    public function testTransaction()
    {
        //$testMoney = new Money(100, 'EUR');
        $testDate = new DateTimeImmutable('2012-12-12');
        $testTransaction = new Transaction (
            '2012-12-12',
            1337,
            'natural',
            'cash_out',
            new Money(100, 'EUR')
        );
        $testMoney = $testTransaction->getMoney();
        $this->assertEquals($testMoney->getAmount(), 100);
        $this->assertEquals($testMoney->getCurrency(), 'EUR');
        $this->assertEquals($testTransaction->getOperationType(), 'cash_out');
        $this->assertEquals($testTransaction->getLegalStatus(), 'natural');
        $this->assertEquals($testTransaction->getId(), 1337);
        $this->assertEquals($testTransaction->getWeeklyEUR(), 0);
        $testTransaction->addThisWeek(100.00, 2);
        $this->assertEquals($testTransaction->getWeeklyEUR(), 100.00);
        $this->assertEquals($testTransaction->getWeeklyTimes(), 2);
    }
}
