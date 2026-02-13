<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mass\Mass;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mass\MassUnit;
use Override;

/**
 * The avoirdupois ounce, a unit of mass in the imperial and US customary systems.
 *
 * Symbol: oz. Conversion factor: 0.028349523125 (1 oz = 0.028349523125 kg).
 * Commonly used for food portions and postal weights in the United States and UK.
 *
 * @see Ounces::make()
 */
final readonly class Ounces extends MassUnit
{
    private const float FACTOR = 0.028349523125;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'oz';
    }
}
