<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Dimensionless\Dimensionless;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Dimensionless\DimensionlessUnit;
use Override;

/**
 * The base dimensionless unit representing a single item.
 *
 * Symbol: ea. Conversion factor: 1 (base unit).
 * Each is the fundamental counting unit from which all other dimensionless
 * units derive their conversion factors.
 *
 * @see Each::make()
 */
final readonly class Each extends DimensionlessUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::one();
    }

    #[Override]
    public function symbol(): string
    {
        return 'ea';
    }
}
