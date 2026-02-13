<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\MagneticFlux;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\MagneticFluxUnit;
use Override;

/**
 * The weber (Wb) — SI derived unit of magnetic flux.
 *
 * One weber is the magnetic flux that, linking a single-turn circuit, induces
 * one volt when reduced uniformly to zero in one second.
 * Factor: 1 (base unit). 1 Wb = 1 V*s = 1 kg*m^2/(A*s^2).
 *
 * @see MagneticFlux::webers()
 */
final readonly class Webers extends MagneticFluxUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'Wb';
    }
}
