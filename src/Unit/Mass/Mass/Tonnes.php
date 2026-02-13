<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mass\Mass;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mass\MassUnit;
use Override;

/**
 * The metric tonne (megagram), equal to 1,000 kilograms.
 *
 * Symbol: t. Conversion factor: 10^3 (1 t = 1,000 kg).
 * Used for large-scale mass measurements in industry, shipping, and agriculture.
 *
 * @see Tonnes::make()
 */
final readonly class Tonnes extends MassUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 't';
    }
}
