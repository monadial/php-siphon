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
final readonly class KilometersPerSecond extends VelocityUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'km/s';
    }
}
