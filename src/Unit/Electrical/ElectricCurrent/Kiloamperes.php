<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricCurrent;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricCurrentUnit;
use Override;

/**
 * The kiloampere (kA) — one thousand amperes.
 *
 * Used in heavy industrial processes such as aluminium smelting and
 * lightning current measurements.
 * Factor: 10^3. 1 kA = 1000 A.
 *
 * @see ElectricCurrent::kiloamperes()
 */
final readonly class Kiloamperes extends ElectricCurrentUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'kA';
    }
}
