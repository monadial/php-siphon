<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Power;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\PowerUnit;
use Override;

/**
 * Kilowatt (kW) -- one thousand watts.
 *
 * Symbol: kW. Conversion factor: 10^3 (1 kW = 1000 W).
 * Commonly used for household appliances and electric vehicle motors.
 * A typical electric kettle draws 2-3 kW.
 *
 * @see Power::kilowatts() for the factory method
 */
final readonly class Kilowatts extends PowerUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'kW';
    }
}
