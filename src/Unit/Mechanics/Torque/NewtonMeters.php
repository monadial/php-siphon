<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Torque;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\TorqueUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class NewtonMeters extends TorqueUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }
}
