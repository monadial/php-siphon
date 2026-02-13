<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Temperature\Temperature;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Temperature\TemperatureUnit;
use Override;

/**
 * The degree Celsius temperature scale, offset from kelvin by 273.15.
 *
 * Symbol: degC. Conversion factor: 1, offset: 273.15 (0 degC = 273.15 K).
 * The Celsius scale sets 0 at the freezing point of water and 100 at its boiling
 * point under standard atmospheric pressure. Uses the same interval size as kelvin.
 *
 * @see Celsius::make()
 */
final readonly class Celsius extends TemperatureUnit
{
    private const float OFFSET = 273.15;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::one();
    }

    #[Override]
    public function symbol(): string
    {
        return 'degC';
    }

    #[Override]
    public function offset(): BigDecimal
    {
        return BigDecimal::of(self::OFFSET);
    }
}
