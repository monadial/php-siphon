<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mass\Mass;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mass\MassUnit;
use Override;

/**
 * One millionth of a gram, or one billionth of a kilogram.
 *
 * Symbol: ug. Conversion factor: 10^-9 (1 ug = 0.000000001 kg).
 * Used in analytical chemistry, toxicology, and trace element measurements.
 *
 * @see Micrograms::make()
 */
final readonly class Micrograms extends MassUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::NANO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'ug';
    }
}
