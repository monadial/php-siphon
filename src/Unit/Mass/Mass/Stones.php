<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mass\Mass;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mass\MassUnit;
use Override;

/**
 * The stone, an imperial unit of mass equal to 14 pounds.
 *
 * Symbol: st. Conversion factor: 6.35029318 (1 st = 6.35029318 kg).
 * Traditionally used in the United Kingdom and Ireland for body weight.
 *
 * @see Stones::make()
 */
final readonly class Stones extends MassUnit
{
    private const float FACTOR = 6.35029318;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'st';
    }
}
