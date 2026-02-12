<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Energy;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\EnergyUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Calories extends EnergyUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('4.184');
    }

    #[Override]
    public function symbol(): string
    {
        return 'cal';
    }
}
