<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Momentum;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\MomentumUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class KilogramMetersPerSecond extends MomentumUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }
}
