<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\MassFlow;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\MassFlowUnit;
use Override;

/**
 * Kilograms per hour (kg/h) -- a common industrial mass flow rate unit.
 *
 * Symbol: kg/h. Conversion factor: 1/3600 (1 kg/h = 0.000278 kg/s approximately).
 * Frequently used in HVAC, boiler systems, and fuel consumption specifications.
 *
 * @see MassFlow::kilogramsPerHour() for the factory method
 */
final readonly class KilogramsPerHour extends MassFlowUnit
{
    private const string FACTOR = '0.00027777777777777778';

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'kg/h';
    }
}
