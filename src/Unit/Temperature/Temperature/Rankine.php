<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Temperature\Temperature;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Temperature\TemperatureUnit;
use Override;

/**
 * The Rankine absolute temperature scale using Fahrenheit-sized degrees.
 *
 * Symbol: degR. Conversion factor: 5/9 (1 degR = 5/9 K), no offset.
 * Like kelvin, Rankine starts at absolute zero but uses the Fahrenheit degree
 * interval. Used in some US engineering thermodynamic calculations.
 *
 * @see Rankine::make()
 */
final readonly class Rankine extends TemperatureUnit
{
    private const string FACTOR = '0.55555555555555555556';

    /**
     * Factor: 5/9 (conversion ratio from Rankine interval to Kelvin interval).
     */
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'degR';
    }
}
