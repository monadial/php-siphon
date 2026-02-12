<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Substance\AmountOfSubstance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Substance\AmountOfSubstanceUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Millimoles extends AmountOfSubstanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MILLI->factor();
    }
}
