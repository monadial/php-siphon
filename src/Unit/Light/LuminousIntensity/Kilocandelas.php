<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Light\LuminousIntensity;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Light\LuminousIntensityUnit;
use Override;

/**
 * One thousand candelas.
 *
 * Symbol: kcd. Conversion factor: 10^3 (1 kcd = 1,000 cd).
 * Used for high-intensity light sources such as searchlights and automotive headlamps.
 *
 * @see Kilocandelas::make()
 */
final readonly class Kilocandelas extends LuminousIntensityUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'kcd';
    }
}
