<?php

declare(strict_types=1);

namespace App\Service\MoneyService;

use App\Models\Money;
use App\Models\Transaction;
use App\Service\MoneyService\CashInLegal;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;

class CashInLegalTest extends TestCase
{
    public function testNormalAmount()
    {
        $date = new DateTimeImmutable('2012-12-12');
        $transaction = new Transaction (
            $date,
            1337,
            'legal',
            'cash_in',
            new Money(10000000, 'EUR')
        );
        $commission = CashInLegal::calculate($transaction);
        $this->assertEquals($commission, new Money(5, 'EUR'));
    }
    public function testSmallAmount()
    {
        $date = new DateTimeImmutable('2012-12-12');
        $transaction = new Transaction (
            $date,
            1337,
            'legal',
            'cash_in',
            new Money(1, 'EUR')
        );
        $commission = CashInLegal::calculate($transaction);
        $this->assertEquals($commission, new Money(0.0003, 'EUR'));
    }
}
