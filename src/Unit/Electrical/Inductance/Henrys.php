<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\Inductance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\InductanceUnit;
use Override;

/**
 * The henry (H) — SI derived unit of inductance.
 *
 * One henry is the inductance that induces one volt of EMF when the current
 * changes at one ampere per second.
 * Factor: 1 (base unit). 1 H = 1 V*s/A = 1 kg*m^2/(A^2*s^2).
 *
 * @see Inductance::henrys()
 */
final readonly class Henrys extends InductanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'H';
    }
}
