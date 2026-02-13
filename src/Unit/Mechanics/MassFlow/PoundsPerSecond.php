<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\MassFlow;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\MassFlowUnit;
use Override;

/**
 * Pounds per second (lb/s) -- an imperial mass flow rate unit.
 *
 * Symbol: lb/s. Conversion factor: 0.45359237 (1 lb/s = 0.45359237 kg/s exactly).
 * Used in US aerospace and industrial applications, particularly for jet engine
 * and rocket propellant mass flow specifications.
 *
 * @see MassFlow::poundsPerSecond() for the factory method
 */
final readonly class PoundsPerSecond extends MassFlowUnit
{
    private const float FACTOR = 0.45359237;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'lb/s';
    }
}
