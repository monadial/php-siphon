<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Energy;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\EnergyUnit;
use Override;

/**
 * Gigawatt-hour (GWh) -- one million kilowatt-hours.
 *
 * Symbol: GWh. Conversion factor: 3,600,000,000,000 (1 GWh = 3.6 TJ).
 * Used for national energy statistics and large power plant output.
 * A typical nuclear reactor produces approximately 7,000-8,000 GWh per year.
 *
 * @see Energy::gigawattHours() for the factory method
 */
final readonly class GigawattHours extends EnergyUnit
{
    private const int FACTOR = 3_600_000_000_000;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'GWh';
    }
}
