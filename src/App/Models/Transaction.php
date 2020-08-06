<?php

declare(strict_types=1);

namespace App\Models;

class Transaction
{
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
        $this->freeWithdrawEUR = 1000;
        $this->freeWithdrawTimes = 3;
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

    public function getWeeklyAmountEUR()
    {
        return $this->freeWithdrawEUR;
    }

    public function getWeeklyAmountTimes()
    {
        return $this->freeWithdrawTimes;
    }

    public function deductFreeWithdrawals(
        float $amountEUR,
        int $times
        ): void {
        $this->freeWithdrawEUR = $this->freeWithdrawEUR - $amountEUR;
        if ($this->freeWithdrawEUR <= 0) {
            $this->freeWithdrawEUR = 0;
        }
        $this->freeWithdrawTimes = $this->freeWithdrawTimes - $times;
    }
}
