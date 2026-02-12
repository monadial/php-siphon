<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Motion\Acceleration;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Motion\AccelerationUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class MetersPerSecondSquared extends AccelerationUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }
}
