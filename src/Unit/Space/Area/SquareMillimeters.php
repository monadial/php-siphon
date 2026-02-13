<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Area;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\AreaUnit;
use Override;

/**
 * Square millimeter (mm^2) -- a unit of area equal to 10^-6 square meters.
 *
 * Used in precision engineering and material science for small cross-sections
 * and surface measurements. A pinhead has an area of roughly 1-2 mm^2.
 *
 * @see Area::squareMillimeters() to create an Area quantity in square millimeters.
 */
final readonly class SquareMillimeters extends AreaUnit
{
    private const float FACTOR = 1e-6;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'mm2';
    }
}
