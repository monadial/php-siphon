<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Energy;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\EnergyUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class BritishThermalUnits extends EnergyUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('1055.05585262');
    }

    #[Override]
    public function symbol(): string
    {
        return 'Btu';
    }
}
