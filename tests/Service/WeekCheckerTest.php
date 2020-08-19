<?php

declare(strict_types=1);

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Service\DataService\WeekChecker;
use App\Models\Transaction;
use App\Models\Money;
use DateTimeImmutable;

class WeekCheckerTest extends TestCase
{
    public function testWeekChecker()
    {
        $date1 = new DateTimeImmutable('2020-08-18');
        $date2 = new DateTimeImmutable('2020-08-17');
        $date3 = new DateTimeImmutable('2020-08-15');
        $true1 = WeekChecker::IsSameWeek($date1, $date2);
        $false1 = WeekChecker::IsSameWeek($date1, $date3);
        $false2 = WeekChecker::IsSameWeek($date2, $date3);
        $this->assertTrue($true1);
        $this->assertFalse($false1);
        $this->assertFalse($false2);
    }
}
