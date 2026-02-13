<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Area;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\AreaUnit;
use Override;

/**
 * Barn (b) -- a unit of area equal to 10^-28 square meters, used in nuclear and particle physics.
 *
 * Originally coined humorously during the Manhattan Project to describe the
 * cross-sectional area of a uranium nucleus, considered "as big as a barn"
 * on the subatomic scale. 1 barn = 100 fm^2.
 *
 * @see Area::barns() to create an Area quantity in barns.
 */
final readonly class Barns extends AreaUnit
{
    private const float FACTOR = 1e-28;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'b';
    }
}
