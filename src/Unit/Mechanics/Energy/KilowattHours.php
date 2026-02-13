<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Energy;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\EnergyUnit;
use Override;

/**
 * Kilowatt-hour (kWh) -- the energy delivered by one kilowatt of power sustained for one hour.
 *
 * Symbol: kWh. Conversion factor: 3,600,000 (1 kWh = 3.6 MJ).
 * The standard billing unit for residential and commercial electricity.
 * An average US household consumes approximately 900 kWh per month.
 *
 * @see Energy::kilowattHours() for the factory method
 */
final readonly class KilowattHours extends EnergyUnit
{
    private const int FACTOR = 3_600_000;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'kWh';
    }
}
