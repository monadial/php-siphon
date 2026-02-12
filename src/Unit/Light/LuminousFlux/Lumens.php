<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Light\LuminousFlux;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Light\LuminousFluxUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Lumens extends LuminousFluxUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }
}
