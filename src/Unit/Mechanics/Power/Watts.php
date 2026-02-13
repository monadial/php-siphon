<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Power;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\PowerUnit;
use Override;

/**
 * Watt (W) -- the SI unit of power.
 *
 * Symbol: W. Conversion factor: 1 (base unit).
 * One watt equals one joule per second (1 W = 1 J/s = 1 kg*m^2/s^3).
 * Named after James Watt. A typical incandescent light bulb uses 60-100 W.
 *
 * @see Power::watts() for the factory method
 */
final readonly class Watts extends PowerUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'W';
    }
}
