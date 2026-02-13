<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Light\LuminousIntensity;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Light\LuminousIntensityUnit;
use Override;

/**
 * The SI base unit of luminous intensity.
 *
 * Symbol: cd. Conversion factor: 1 (base unit).
 * Defined as the luminous power per unit solid angle emitted by a light source
 * in a particular direction, approximately the light of one common candle.
 *
 * @see Candelas::make()
 */
final readonly class Candelas extends LuminousIntensityUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'cd';
    }
}
