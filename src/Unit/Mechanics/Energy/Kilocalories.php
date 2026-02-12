<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Energy;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\EnergyUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Kilocalories extends EnergyUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('4184');
    }

    #[Override]
    public function symbol(): string
    {
        return 'kcal';
    }
}
