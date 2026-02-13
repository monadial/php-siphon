<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mass\Mass;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mass\MassUnit;
use Override;

/**
 * The SI base unit of mass.
 *
 * Symbol: kg. Conversion factor: 1 (base unit).
 * The kilogram is defined by the Planck constant and is the only SI base unit
 * that includes a metric prefix in its name.
 *
 * @see Kilograms::make()
 */
final readonly class Kilograms extends MassUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'kg';
    }
}
