<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Length;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Space\LengthUnit;
use Override;

/**
 * Decameter (dam) -- a unit of length equal to 10 meters.
 *
 * Uncommonly used in practice but part of the complete set of SI metric prefixes.
 * Roughly the width of a bowling lane (approximately 18 m including gutters).
 *
 * @see Length::decameters() to create a Length quantity in decameters.
 */
final readonly class Decameters extends LengthUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::DECA->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'dam';
    }
}
