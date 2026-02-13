<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Pressure;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\PressureUnit;
use Override;

/**
 * Millimeter of mercury (mmHg) -- a manometric pressure unit.
 *
 * Symbol: mmHg. Conversion factor: 133.322 (1 mmHg = 133.322 Pa approximately).
 * Defined by the hydrostatic pressure of a one-millimeter column of mercury.
 * The standard unit for reporting blood pressure (e.g. 120/80 mmHg).
 *
 * @see Pressure::millimetersOfMercury() for the factory method
 */
final readonly class MillimetersOfMercury extends PressureUnit
{
    private const float FACTOR = 133.322387415;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'mmHg';
    }
}
