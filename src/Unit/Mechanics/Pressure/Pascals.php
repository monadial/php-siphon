<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Pressure;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\PressureUnit;
use Override;

/**
 * Pascal (Pa) -- the SI unit of pressure.
 *
 * Symbol: Pa. Conversion factor: 1 (base unit).
 * One pascal equals one newton per square meter (1 Pa = 1 N/m^2 = 1 kg/(m*s^2)).
 * Named after Blaise Pascal. Standard atmospheric pressure is 101,325 Pa.
 *
 * @see Pressure::pascals() for the factory method
 */
final readonly class Pascals extends PressureUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'Pa';
    }
}
