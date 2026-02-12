<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\MagneticFlux;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\MagneticFluxUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Microwebers extends MagneticFluxUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MICRO->factor();
    }
}
