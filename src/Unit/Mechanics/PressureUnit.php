<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base class for all pressure units of measure.
 *
 * Each concrete subclass represents a specific pressure unit (e.g. pascals, bars, atm)
 * and provides its conversion factor relative to the SI base unit (pascal).
 *
 * @see Pressure for the quantity class that uses these units
 */
abstract readonly class PressureUnit extends UnitOfMeasure
{
}
