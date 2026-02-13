<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Energy;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\EnergyUnit;
use Override;

/**
 * Watt-hour (Wh) -- the energy delivered by one watt of power sustained for one hour.
 *
 * Symbol: Wh. Conversion factor: 3600 (1 Wh = 3600 J).
 * Commonly used for battery capacity and small-scale electrical energy metering.
 * A typical smartphone battery holds 10-15 Wh.
 *
 * @see Energy::wattHours() for the factory method
 */
final readonly class WattHours extends EnergyUnit
{
    private const int FACTOR = 3600;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'Wh';
    }
}
