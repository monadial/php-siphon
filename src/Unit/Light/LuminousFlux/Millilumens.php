<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Light\LuminousFlux;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Light\LuminousFluxUnit;
use Override;

/**
 * One thousandth of a lumen.
 *
 * Symbol: mlm. Conversion factor: 10^-3 (1 mlm = 0.001 lm).
 * Used for measuring very low light output such as indicator LEDs.
 *
 * @see Millilumens::make()
 */
final readonly class Millilumens extends LuminousFluxUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MILLI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'mlm';
    }
}
