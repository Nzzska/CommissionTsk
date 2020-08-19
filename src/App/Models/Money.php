<?php

declare(strict_types=1);

namespace App\Models;

use App\Controllers\ParamsController;

class Money
{
    private static $hasCents = [
        'EUR' => true,
        'USD' => true,
        'JPY' => false,
    ];

    private $amount;
    private $currency;

    public function __construct($amount, $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public static function getRate(string $currency): float
    {
        return ParamsController::getRate($currency);
    }

    public static function getCentsStatus(string $currency): bool
    {
        return ParamsController::getCentsStatus($currency);
    }
}
