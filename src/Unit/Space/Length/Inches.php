<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Length;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\LengthUnit;
use Override;

/**
 * Inch (in) -- an imperial/US customary unit of length equal to exactly 0.0254 meters.
 *
 * Defined as exactly 25.4 millimeters by international agreement since 1959.
 * Widely used in the US and UK for everyday measurements, screen sizes, and hardware.
 *
 * @see Length::inches() to create a Length quantity in inches.
 */
final readonly class Inches extends LengthUnit
{
    private const float FACTOR = 0.0254;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'in';
    }
}
