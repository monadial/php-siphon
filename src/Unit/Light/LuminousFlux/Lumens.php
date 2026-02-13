<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Light\LuminousFlux;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Light\LuminousFluxUnit;
use Override;

/**
 * The SI derived unit of luminous flux.
 *
 * Symbol: lm. Conversion factor: 1 (base unit).
 * One lumen equals the luminous flux emitted by a source of one candela
 * intensity through a solid angle of one steradian.
 *
 * @see Lumens::make()
 */
final readonly class Lumens extends LuminousFluxUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'lm';
    }
}
