<?php

declare(strict_types=1);

namespace App\Models;

use App\Controllers\ParamsController;

class Money
{
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

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getRate(): string
    {
        return ParamsController::getRate($this->currency);
    }

    public function getCentsStatus(): bool
    {
        return ParamsController::getCentsStatus($this->currency);
    }
}
