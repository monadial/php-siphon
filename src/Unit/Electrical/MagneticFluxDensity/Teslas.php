<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\MagneticFluxDensity;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\MagneticFluxDensityUnit;
use Override;

/**
 * The tesla (T) — SI derived unit of magnetic flux density.
 *
 * One tesla equals one weber per square meter, or equivalently one kilogram
 * per ampere per second squared.
 * Factor: 1 (base unit). 1 T = 1 Wb/m^2 = 1 kg/(A*s^2).
 *
 * @see MagneticFluxDensity::teslas()
 */
final readonly class Teslas extends MagneticFluxDensityUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'T';
    }
}
