<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Motion\Velocity;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Motion\VelocityUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class MetersPerSecond extends VelocityUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'm/s';
    }
}
