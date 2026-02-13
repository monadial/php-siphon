<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base class for all volume flow rate units of measure.
 *
 * Each concrete subclass represents a specific volume flow unit (e.g. m^3/s, L/min)
 * and provides its conversion factor relative to the SI base unit (cubic meters per second).
 *
 * @see VolumeFlow for the quantity class that uses these units
 */
abstract readonly class VolumeFlowUnit extends UnitOfMeasure
{
}
