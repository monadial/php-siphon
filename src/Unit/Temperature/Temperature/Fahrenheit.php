<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Temperature\Temperature;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Temperature\TemperatureUnit;
use Override;

/**
 * The degree Fahrenheit temperature scale used in the United States.
 *
 * Symbol: degF. Conversion factor: 5/9, offset: 459.67 (0 degF = 255.372 K).
 * The Fahrenheit scale sets 32 at the freezing point of water and 212 at its
 * boiling point. One Fahrenheit degree is 5/9 the size of one kelvin.
 *
 * @see Fahrenheit::make()
 */
final readonly class Fahrenheit extends TemperatureUnit
{
    private const string FACTOR = '0.55555555555555555556';
    private const float OFFSET = 459.67;

    /**
     * Factor: 5/9 (conversion ratio from Fahrenheit interval to Kelvin interval).
     */
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'degF';
    }

    #[Override]
    public function offset(): BigDecimal
    {
        return BigDecimal::of(self::OFFSET);
    }
}
