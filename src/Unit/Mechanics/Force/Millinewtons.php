<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Force;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\ForceUnit;
use Override;

/**
 * Millinewton (mN) -- one thousandth of a newton.
 *
 * Symbol: mN. Conversion factor: 10^-3 (1 mN = 0.001 N).
 * Used in precision engineering, microelectromechanical systems (MEMS),
 * and small-scale force measurements such as surface tension experiments.
 *
 * @see Force::millinewtons() for the factory method
 */
final readonly class Millinewtons extends ForceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MILLI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'mN';
    }
}
