<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Light\LuminousIntensity;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Light\LuminousIntensityUnit;
use Override;

/**
 * One thousandth of a candela.
 *
 * Symbol: mcd. Conversion factor: 10^-3 (1 mcd = 0.001 cd).
 * Commonly used to specify the brightness of individual LEDs and indicator lights.
 *
 * @see Millicandelas::make()
 */
final readonly class Millicandelas extends LuminousIntensityUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MILLI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'mcd';
    }
}
