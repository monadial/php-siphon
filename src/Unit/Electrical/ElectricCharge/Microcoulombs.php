<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricCharge;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricChargeUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Microcoulombs extends ElectricChargeUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MICRO->factor();
    }
}
