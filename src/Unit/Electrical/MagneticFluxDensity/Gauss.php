<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\MagneticFluxDensity;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Electrical\MagneticFluxDensityUnit;
use Override;

/**
 * The gauss (Gs) — CGS unit of magnetic flux density.
 *
 * Widely used in engineering despite not being an SI unit. One gauss equals
 * one maxwell per square centimetre. Named after Carl Friedrich Gauss.
 * Factor: 10^-4. 1 Gs = 0.0001 T.
 *
 * @see MagneticFluxDensity::gauss()
 */
final readonly class Gauss extends MagneticFluxDensityUnit
{
    private const float FACTOR = 1e-4;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'Gs';
    }
}
