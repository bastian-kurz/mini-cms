<?php

declare(strict_types=1);

namespace App\Api\OpenApi\Generator;

use OpenApi\Analysis;

class DeactivateValidationAnalysis extends Analysis
{
    public function validate(): bool
    {
        return true;
    }
}
