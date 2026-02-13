<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mass\Mass;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mass\MassUnit;
use Override;

/**
 * One thousandth of a gram, or one millionth of a kilogram.
 *
 * Symbol: mg. Conversion factor: 10^-6 (1 mg = 0.000001 kg).
 * Commonly used in pharmacology for drug dosages and in nutrition labeling.
 *
 * @see Milligrams::make()
 */
final readonly class Milligrams extends MassUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MICRO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'mg';
    }
}
