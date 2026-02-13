<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Dimensionless\Dimensionless;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Dimensionless\DimensionlessUnit;
use Override;

/**
 * A counting unit representing one hundred forty-four items (a dozen dozens).
 *
 * Symbol: gr. Conversion factor: 144 (1 gross = 144 each).
 * Traditionally used in wholesale and manufacturing for bulk item counts.
 *
 * @see Gross::make()
 */
final readonly class Gross extends DimensionlessUnit
{
    private const int FACTOR = 144;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'gr';
    }
}
