<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Length;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Space\LengthUnit;
use Override;

/**
 * Nanometer (nm) -- a unit of length equal to 10^-9 meters.
 *
 * Commonly used to measure wavelengths of light, molecular dimensions,
 * and semiconductor feature sizes. Visible light ranges from about 380 nm to 700 nm.
 *
 * @see Length::nanometers() to create a Length quantity in nanometers.
 */
final readonly class Nanometers extends LengthUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::NANO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'nm';
    }
}
