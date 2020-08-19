<?php

declare(strict_types=1);

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Service\MoneyService\CurrencyConverter;
use App\Models\Money;

class CurrencyConverterTest extends TestCase
{
    public function testUSDtoEUR ()
    {
        $USD = new Money (1, 'USD');
        $EUR = CurrencyConverter::convert($USD, 'EUR');
        $this->assertEquals($EUR->getAmount(), 1/1.1497);
    }
    public function testUSDtoJPY ()
    {
        $USD = new Money (1, 'USD');
        $JPY = CurrencyConverter::convert($USD, 'JPY');
        $this->assertEquals($JPY->getAmount(), 1/1.1497 * 129.53);
    }
    public function testEURtoUSD()
    {
        $EUR = new Money (1, 'EUR');
        $USD = CurrencyConverter::convert($EUR, 'USD');
        $this->assertEquals($USD->getAmount(), 1.1497);
    }
    public function testEURtoJPY()
    {
        $EUR = new Money (1, 'EUR');
        $JPY = CurrencyConverter::convert($EUR, 'JPY');
        $this->assertEquals($JPY->getAmount(), 129.53);
    }
    public function testJPYtoEUR()
    {
        $JPY = new Money (129.53,'JPY');
        $EUR = CurrencyConverter::convert($JPY, 'EUR');
        $this->assertEquals($EUR->getAmount(), 1);
    }
    public function testJPYtoUSD()
    {
        $JPY = new Money (129.53, 'JPY');
        $USD = CurrencyConverter::convert($JPY, 'USD');
        $this->assertEquals($USD->getAmount(), 1.1497);
    }
}
