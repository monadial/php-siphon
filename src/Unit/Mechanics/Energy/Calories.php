<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Energy;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\EnergyUnit;
use Override;

/**
 * Calorie (cal) -- the thermochemical calorie.
 *
 * Symbol: cal. Conversion factor: 4.184 (1 cal = 4.184 J).
 * Originally defined as the energy needed to raise the temperature of one gram
 * of water by one degree Celsius. Used in chemistry and some scientific contexts.
 *
 * @see Energy::calories() for the factory method
 */
final readonly class Calories extends EnergyUnit
{
    private const float FACTOR = 4.184;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'cal';
    }
}
