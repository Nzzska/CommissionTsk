<?php

declare(strict_types=1);

namespace App\Models;

class ParametersGatherer
//this is where I assume we'd add database or API calls.
{
    public static function getSupportedOperationTypes(): array
    {
        return ['cash_in', 'cash_out'];
    }

    public static function getSupportedEntityStatuses(): array
    {
        return ['legal', 'natural'];
    }
}
