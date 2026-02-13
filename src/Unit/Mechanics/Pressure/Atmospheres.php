<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Pressure;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\PressureUnit;
use Override;

/**
 * Standard atmosphere (atm) -- a reference pressure defined as 101,325 Pa exactly.
 *
 * Symbol: atm. Conversion factor: 101,325 (1 atm = 101,325 Pa).
 * Defined as the mean atmospheric pressure at sea level. Used as a reference in
 * chemistry (standard conditions), diving, and aviation.
 *
 * @see Pressure::atmospheres() for the factory method
 */
final readonly class Atmospheres extends PressureUnit
{
    private const int FACTOR = 101_325;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'atm';
    }
}
