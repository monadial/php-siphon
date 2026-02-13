<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Pressure;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\PressureUnit;
use Override;

/**
 * Megapascal (MPa) -- one million pascals.
 *
 * Symbol: MPa. Conversion factor: 10^6 (1 MPa = 1,000,000 Pa).
 * Used for material strength specifications (yield stress, tensile strength).
 * Structural steel typically has a yield strength of 250-350 MPa.
 *
 * @see Pressure::megapascals() for the factory method
 */
final readonly class Megapascals extends PressureUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MEGA->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'MPa';
    }
}
