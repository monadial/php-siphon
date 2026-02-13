<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Motion\Velocity;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Motion\VelocityUnit;
use Override;

/**
 * Velocity in kilometers per hour.
 *
 * Symbol: km/h. Conversion factor: 1/3.6 (1 km/h = 0.2778 m/s).
 * The most widely used unit for road vehicle speed worldwide.
 *
 * @see KilometersPerHour::make()
 */
final readonly class KilometersPerHour extends VelocityUnit
{
    private const string FACTOR = '0.27777777777777777778';

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'km/h';
    }
}
