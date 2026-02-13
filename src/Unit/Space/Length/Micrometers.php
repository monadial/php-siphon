<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Length;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Space\LengthUnit;
use Override;

/**
 * Micrometer (um) -- a unit of length equal to 10^-6 meters.
 *
 * Also known as a micron. Commonly used to measure cell sizes, bacteria,
 * and manufacturing tolerances. A human hair is roughly 70 um in diameter.
 *
 * @see Length::micrometers() to create a Length quantity in micrometers.
 */
final readonly class Micrometers extends LengthUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MICRO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'um';
    }
}
