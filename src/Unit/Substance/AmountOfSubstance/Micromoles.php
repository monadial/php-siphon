<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Substance\AmountOfSubstance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Substance\AmountOfSubstanceUnit;
use Override;

/**
 * One millionth of a mole.
 *
 * Symbol: umol. Conversion factor: 10^-6 (1 umol = 0.000001 mol).
 * Used in biochemistry for trace concentrations and enzymatic assays.
 *
 * @see Micromoles::make()
 */
final readonly class Micromoles extends AmountOfSubstanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MICRO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'umol';
    }
}
