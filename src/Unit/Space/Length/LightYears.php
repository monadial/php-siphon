<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Length;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\LengthUnit;
use Override;

/**
 * Light-year (ly) -- a unit of length equal to approximately 9.461 * 10^15 meters.
 *
 * The distance that light travels in vacuum in one Julian year (365.25 days).
 * Used in astronomy to express interstellar and intergalactic distances.
 * The nearest star, Proxima Centauri, is about 4.24 light-years from the Sun.
 *
 * @see Length::lightYears() to create a Length quantity in light-years.
 */
final readonly class LightYears extends LengthUnit
{
    private const float FACTOR = 9.4607304725808e15;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'ly';
    }
}
