<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Pressure;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\PressureUnit;
use Override;

/**
 * Millibar (mbar) -- one thousandth of a bar, equal to one hectopascal.
 *
 * Symbol: mbar. Conversion factor: 100 (1 mbar = 100 Pa = 1 hPa).
 * The traditional unit for reporting atmospheric pressure in meteorology.
 * Standard sea-level pressure is 1013.25 mbar.
 *
 * @see Pressure::millibars() for the factory method
 */
final readonly class Millibars extends PressureUnit
{
    private const int FACTOR = 100;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'mbar';
    }
}
