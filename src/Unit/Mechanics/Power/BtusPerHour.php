<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Power;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\PowerUnit;
use Override;

/**
 * BTU per hour (BTU/h) -- an imperial/US customary unit of power.
 *
 * Symbol: Btu/h. Conversion factor: 0.29307107 (1 BTU/h = 0.293 W approximately).
 * The standard unit for rating heating and cooling equipment capacity in the US.
 * A typical residential furnace is rated at 60,000-100,000 BTU/h.
 *
 * @see Power::btusPerHour() for the factory method
 */
final readonly class BtusPerHour extends PowerUnit
{
    private const string FACTOR = '0.29307107017222222222';

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'Btu/h';
    }
}
