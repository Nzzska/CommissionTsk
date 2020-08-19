<?php

declare(strict_types=1);

namespace App\Service\MoneyService;

use App\Models\Money;
use App\Models\Transaction;
use App\Service\MoneyService\CashInNatural;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;

class CashInNaturalTest extends TestCase
{
    public function testOverMaximum(){
        $date = new DateTimeImmutable('2012-12-12');
        $transaction = new Transaction (
            $date,
            1337,
            'natural',
            'cash_in',
            new Money(10000000, 'EUR')
        );
        $commission = CashInNatural::calculate($transaction);
        $this->assertEquals($commission, new Money(5, 'EUR'));
    }

    public function testNormal(){
        $date = new DateTimeImmutable('2012-12-12');
        $transaction = new Transaction (
            $date,
            1337,
            'legal',
            'cash_in',
            new Money(100, 'EUR')
        );
        $commission = CashInNatural::calculate($transaction);
        $this->assertEquals($commission, new Money(0.03, 'EUR'));
    }
}
