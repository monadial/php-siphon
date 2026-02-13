<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Area;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\AreaUnit;
use Override;

/**
 * Square centimeter (cm^2) -- a unit of area equal to 10^-4 square meters.
 *
 * Common in everyday contexts such as body surface area, paper sizes,
 * and medical dosage calculations. A US postage stamp is about 6 cm^2.
 *
 * @see Area::squareCentimeters() to create an Area quantity in square centimeters.
 */
final readonly class SquareCentimeters extends AreaUnit
{
    private const float FACTOR = 1e-4;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'cm2';
    }
}
