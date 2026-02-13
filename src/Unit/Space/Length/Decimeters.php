<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Length;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Space\LengthUnit;
use Override;

/**
 * Decimeter (dm) -- a unit of length equal to 10^-1 meters.
 *
 * Rarely used in everyday life but important because a cubic decimeter
 * equals exactly one litre. 1 dm = 10 cm.
 *
 * @see Length::decimeters() to create a Length quantity in decimeters.
 */
final readonly class Decimeters extends LengthUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::DECI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'dm';
    }
}
