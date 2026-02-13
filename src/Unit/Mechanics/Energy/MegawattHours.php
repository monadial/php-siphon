<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Energy;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\EnergyUnit;
use Override;

/**
 * Megawatt-hour (MWh) -- one thousand kilowatt-hours.
 *
 * Symbol: MWh. Conversion factor: 3,600,000,000 (1 MWh = 3.6 GJ).
 * Used in wholesale electricity markets and industrial energy accounting.
 * A typical wind turbine can produce 6-7 MWh per day.
 *
 * @see Energy::megawattHours() for the factory method
 */
final readonly class MegawattHours extends EnergyUnit
{
    private const int FACTOR = 3_600_000_000;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'MWh';
    }
}
