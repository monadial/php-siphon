<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\VolumeFlow;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\VolumeFlowUnit;
use Override;

/**
 * Litres per minute (L/min) -- a commonly used volume flow rate unit.
 *
 * Symbol: L/min. Conversion factor: 1/60,000 (1 L/min = 1.667e-5 m^3/s approximately).
 * Widely used in medical gas delivery, aquarium filtration, and small pump
 * specifications. A typical showerhead uses 8-12 L/min.
 *
 * @see VolumeFlow::litresPerMinute() for the factory method
 */
final readonly class LitresPerMinute extends VolumeFlowUnit
{
    private const string FACTOR = '0.00001666666666666667';

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'L/min';
    }
}
