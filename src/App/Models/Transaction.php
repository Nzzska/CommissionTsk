<?php

declare(strict_types=1);

namespace App\Models;

class Transaction
{
    private $amountCurrency;
    private $freeWithdrawEUR;
    private $freeWithdrawTimes;
    private $date;
    private $id;
    private $legalStatus;
    private $operationType;

    public function __construct(
        $date,
        $id,
        $legalStatus,
        $operationType,
        $amountCurrency
    ) {
        $this->date = $date;
        $this->id = $id;
        $this->legalStatus = $legalStatus;
        $this->operationType = $operationType;
        $this->amountCurrency = $amountCurrency;
        $this->thisWeekEUR = 0;
        $this->thisWeekTimes = 0;
    }

    public function setAmountCurrency($money)
    {
        $this->AmountCurrency = $money;
    }

    public function getMoney()
    {
        return $this->amountCurrency;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getLegalStatus()
    {
        return $this->legalStatus;
    }

    public function getOperationType()
    {
        return $this->operationType;
    }

    public function getCurrency()
    {
        return $this->amountCurrency->getCurrency();
    }

    public function getAmount()
    {
        return $this->amountCurrency->getAmount();
    }

    public function getWeeklyEUR()
    {
        return $this->thisWeekEUR;
    }

    public function getWeeklyTimes()
    {
        return $this->thisWeekTimes;
    }

    public function addThisWeek(
        float $amountEUR,
        int $times
        ): void {
        $this->thisWeekEUR = $this->thisWeekEUR + $amountEUR;
        $this->thisWeekTimes = $this->thisWeekTimes + $times;
    }
}
