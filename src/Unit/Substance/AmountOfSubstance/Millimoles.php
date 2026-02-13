<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Substance\AmountOfSubstance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Substance\AmountOfSubstanceUnit;
use Override;

/**
 * One thousandth of a mole.
 *
 * Symbol: mmol. Conversion factor: 10^-3 (1 mmol = 0.001 mol).
 * Widely used in clinical chemistry and blood test results (e.g., blood glucose in mmol/L).
 *
 * @see Millimoles::make()
 */
final readonly class Millimoles extends AmountOfSubstanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MILLI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'mmol';
    }
}
