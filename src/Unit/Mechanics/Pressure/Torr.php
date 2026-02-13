<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Pressure;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\PressureUnit;
use Override;

/**
 * Torr (Torr) -- a pressure unit defined as 1/760 of a standard atmosphere.
 *
 * Symbol: Torr. Conversion factor: 133.322 (1 Torr = 133.322 Pa approximately).
 * Named after Evangelista Torricelli, inventor of the barometer. Used primarily
 * in vacuum technology and low-pressure gas measurements.
 *
 * @see Pressure::torr() for the factory method
 */
final readonly class Torr extends PressureUnit
{
    private const string FACTOR = '133.32236842105263158';

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'Torr';
    }
}
