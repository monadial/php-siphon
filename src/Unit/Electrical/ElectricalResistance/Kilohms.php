<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricalResistance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricalResistanceUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Kilohms extends ElectricalResistanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }
}
