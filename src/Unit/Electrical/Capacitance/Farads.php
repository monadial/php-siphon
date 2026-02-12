<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\Capacitance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\CapacitanceUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Farads extends CapacitanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }
}
