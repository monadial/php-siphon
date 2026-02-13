<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Energy;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\EnergyUnit;
use Override;

/**
 * Joule (J) -- the SI unit of energy, work, and heat.
 *
 * Symbol: J. Conversion factor: 1 (base unit).
 * One joule equals the work done by a force of one newton acting over one meter
 * (1 J = 1 kg*m^2/s^2). Named after James Prescott Joule.
 *
 * @see Energy::joules() for the factory method
 */
final readonly class Joules extends EnergyUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'J';
    }
}
