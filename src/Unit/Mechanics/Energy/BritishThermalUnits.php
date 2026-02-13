<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Energy;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\EnergyUnit;
use Override;

/**
 * British Thermal Unit (BTU) -- an imperial/US customary unit of heat energy.
 *
 * Symbol: Btu. Conversion factor: 1055.06 (1 BTU = 1055.06 J approximately).
 * Defined as the energy needed to raise the temperature of one pound of water
 * by one degree Fahrenheit. Widely used in HVAC and energy industries in the US.
 *
 * @see Energy::britishThermalUnits() for the factory method
 */
final readonly class BritishThermalUnits extends EnergyUnit
{
    private const float FACTOR = 1055.05585262;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'Btu';
    }
}
