<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Pressure;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\PressureUnit;
use Override;

/**
 * Kilopascal (kPa) -- one thousand pascals.
 *
 * Symbol: kPa. Conversion factor: 10^3 (1 kPa = 1000 Pa).
 * Commonly used for atmospheric pressure and tire pressure specifications.
 * Standard atmospheric pressure is approximately 101.325 kPa.
 *
 * @see Pressure::kilopascals() for the factory method
 */
final readonly class Kilopascals extends PressureUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'kPa';
    }
}
