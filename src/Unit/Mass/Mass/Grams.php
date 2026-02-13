<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mass\Mass;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mass\MassUnit;
use Override;

/**
 * The CGS base unit of mass, equal to one thousandth of a kilogram.
 *
 * Symbol: g. Conversion factor: 10^-3 (1 g = 0.001 kg).
 * Widely used in chemistry, cooking, and everyday measurements.
 *
 * @see Grams::make()
 */
final readonly class Grams extends MassUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MILLI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'g';
    }
}
