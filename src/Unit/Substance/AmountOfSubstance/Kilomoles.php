<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Substance\AmountOfSubstance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Substance\AmountOfSubstanceUnit;
use Override;

/**
 * One thousand moles.
 *
 * Symbol: kmol. Conversion factor: 10^3 (1 kmol = 1,000 mol).
 * Used in industrial chemistry and chemical engineering for large-scale reactions.
 *
 * @see Kilomoles::make()
 */
final readonly class Kilomoles extends AmountOfSubstanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'kmol';
    }
}
