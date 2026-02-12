<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricalConductance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricalConductanceUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Microsiemens extends ElectricalConductanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MICRO->factor();
    }
}
