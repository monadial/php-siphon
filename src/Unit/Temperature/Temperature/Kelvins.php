<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Temperature\Temperature;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Temperature\TemperatureUnit;
use Override;

/**
 * The SI base unit of thermodynamic temperature.
 *
 * Symbol: K. Conversion factor: 1 (base unit).
 * The kelvin is defined by fixing the Boltzmann constant at 1.380649 x 10^-23 J/K.
 * Zero kelvins is absolute zero, the lowest possible temperature.
 *
 * @see Kelvins::make()
 */
final readonly class Kelvins extends TemperatureUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'K';
    }
}
