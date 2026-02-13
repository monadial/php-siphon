<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Pressure;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\PressureUnit;
use Override;

/**
 * Pounds per square inch (psi) -- an imperial/US customary unit of pressure.
 *
 * Symbol: psi. Conversion factor: 6894.757 (1 psi = 6894.757 Pa approximately).
 * Widely used in the US for tire pressure, hydraulic systems, and compressed gas
 * specifications. Standard atmospheric pressure is approximately 14.696 psi.
 *
 * @see Pressure::poundsPerSquareInch() for the factory method
 */
final readonly class PoundsPerSquareInch extends PressureUnit
{
    private const float FACTOR = 6894.757293168;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'psi';
    }
}
