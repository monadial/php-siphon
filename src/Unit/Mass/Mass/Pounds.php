<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mass\Mass;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mass\MassUnit;
use Override;

/**
 * The avoirdupois pound, a unit of mass in the imperial and US customary systems.
 *
 * Symbol: lb. Conversion factor: 0.45359237 (1 lb = 0.45359237 kg exactly).
 * The international pound is defined as exactly 0.45359237 kilograms.
 *
 * @see Pounds::make()
 */
final readonly class Pounds extends MassUnit
{
    private const float FACTOR = 0.45359237;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'lb';
    }
}
