<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Area;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\AreaUnit;
use Override;

/**
 * Square inch (in^2) -- an imperial/US customary unit of area equal to 0.00064516 square meters.
 *
 * Derived from the inch (0.0254 m)^2. Used in the US and UK for material
 * specifications, display sizes, and pressure (psi = pounds per square inch).
 *
 * @see Area::squareInches() to create an Area quantity in square inches.
 */
final readonly class SquareInches extends AreaUnit
{
    private const float FACTOR = 6.4516e-4;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'in2';
    }
}
