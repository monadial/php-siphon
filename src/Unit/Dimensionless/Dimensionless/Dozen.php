<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Dimensionless\Dimensionless;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Dimensionless\DimensionlessUnit;
use Override;

/**
 * A counting unit representing twelve items.
 *
 * Symbol: doz. Conversion factor: 12 (1 dozen = 12 each).
 * Commonly used in commerce and everyday counting.
 *
 * @see Dozen::make()
 */
final readonly class Dozen extends DimensionlessUnit
{
    private const int FACTOR = 12;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'doz';
    }
}
