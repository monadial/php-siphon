<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Motion\Velocity;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Motion\VelocityUnit;
use Override;

/**
 * Nautical velocity unit equal to one nautical mile per hour.
 *
 * Symbol: kn. Conversion factor: 0.514444 (1 kn = 0.514444 m/s).
 * The standard unit of speed in maritime and aviation navigation.
 *
 * @see Knots::make()
 */
final readonly class Knots extends VelocityUnit
{
    private const string FACTOR = '0.51444444444444444444';

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'kn';
    }
}
