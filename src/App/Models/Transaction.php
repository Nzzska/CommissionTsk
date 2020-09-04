<?php

declare(strict_types=1);

namespace App\Models;

use DateTimeImmutable;

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
        $this->thisWeekEUR = '0';
        $this->thisWeekTimes = 0;
    }

    public function setAmountCurrency($money)
    {
        $this->AmountCurrency = $money;
    }

    public function getMoney(): Money
    {
        return $this->amountCurrency;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getLegalStatus(): string
    {
        return $this->legalStatus;
    }

    public function getOperationType(): string
    {
        return $this->operationType;
    }

    public function getCurrency(): string
    {
        return $this->amountCurrency->getCurrency();
    }

    public function getAmount(): string
    {
        return $this->amountCurrency->getAmount();
    }

    public function getWeeklyEUR(): string
    {
        return $this->thisWeekEUR;
    }

    public function getWeeklyTimes(): int
    {
        return $this->thisWeekTimes;
    }

    public function addThisWeek(
        string $amountEUR,
        int $times
        ): void {
        $this->thisWeekEUR = bcadd($this->thisWeekEUR, $amountEUR);
        $this->thisWeekTimes = $this->thisWeekTimes + $times;
    }
}
