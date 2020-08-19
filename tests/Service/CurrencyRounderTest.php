<?php

declare(strict_types=1);

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Models\Money;
use App\Service\MoneyService\CurrencyRounder;

class CurrencyRounderTest extends TestCase
{
    public function testRoundUSD()
    {
        $round05 = new Money (0.505 , 'USD');
        $round06 = new Money (0.506 , 'USD');
        $round04 = new Money (0.504 , 'USD');
        $result05 = CurrencyRounder::roundCurrency($round05);
        $result06 = CurrencyRounder::roundCurrency($round06);
        $result04 = CurrencyRounder::roundCurrency($round04);
        $amount05 = $result05->getAmount();
        $amount06 = $result06->getAmount();
        $amount04 = $result04->getAmount();
        $results = [$amount05, $amount06, $amount04];
        $this->assertEquals($results, [0.51, 0.51, 0.51]);
    }
    public function testRoundJPY()
    {
        $round05 = new Money (0.5 , 'JPY');
        $round04 = new Money (0.4 , 'JPY');
        $round214 = new Money (2.14 , 'JPY');
        $result05 = CurrencyRounder::roundCurrency($round05);
        $result214 = CurrencyRounder::roundCurrency($round214);
        $result04 = CurrencyRounder::roundCurrency($round04);
        $amount05 = $result05->getAmount();
        $amount214 = $result214->getAmount();
        $amount04 = $result04->getAmount();
        $results = [$amount05, $amount214, $amount04];
        $this->assertEquals($results, [1, 3, 1]);
    }
}
