<?php

declare(strict_types=1);

namespace App\Service\MoneyService;

use App\Models\Money;
use App\Models\Transaction;
use App\Service\MoneyService\CashOutNatural;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;

class TestCashInNatural extends TestCase
{
    public function testNormalAmount()
    {
        $date = new DateTimeImmutable('2012-12-12');
        $transaction = new Transaction (
            $date,
            1337,
            'legal',
            'cash_out',
            new Money(10000000, 'EUR')
        );
        $commission = CashOutNatural::calculate($transaction);
        $this->assertEquals($commission, new Money(29997, 'EUR'));
    }
}
