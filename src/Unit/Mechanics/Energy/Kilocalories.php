<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Energy;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\EnergyUnit;
use Override;

/**
 * Kilocalorie (kcal) -- one thousand calories, the "food Calorie."
 *
 * Symbol: kcal. Conversion factor: 4184 (1 kcal = 4184 J).
 * The unit commonly labeled "Calorie" (capital C) in nutrition labels.
 * An average adult requires approximately 2000 kcal per day.
 *
 * @see Energy::kilocalories() for the factory method
 */
final readonly class Kilocalories extends EnergyUnit
{
    private const int FACTOR = 4184;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'kcal';
    }
}
