<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Light\LuminousFlux;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Light\LuminousFluxUnit;
use Override;

/**
 * One thousand lumens.
 *
 * Symbol: klm. Conversion factor: 10^3 (1 klm = 1,000 lm).
 * Used for high-output lighting such as projectors and stadium lights.
 *
 * @see Kilolumens::make()
 */
final readonly class Kilolumens extends LuminousFluxUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'klm';
    }
}
