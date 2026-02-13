<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Dimensionless\Dimensionless;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Dimensionless\DimensionlessUnit;
use Override;

/**
 * A dimensionless unit representing one hundredth of a whole.
 *
 * Symbol: %. Conversion factor: 0.01 (1% = 0.01 each).
 * Widely used to express ratios, proportions, and fractional amounts.
 *
 * @see Percent::make()
 */
final readonly class Percent extends DimensionlessUnit
{
    private const float FACTOR = 0.01;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return '%';
    }
}
