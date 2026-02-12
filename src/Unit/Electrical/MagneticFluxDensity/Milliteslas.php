<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\MagneticFluxDensity;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\MagneticFluxDensityUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Milliteslas extends MagneticFluxDensityUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MILLI->factor();
    }
}
