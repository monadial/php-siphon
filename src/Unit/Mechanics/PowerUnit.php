<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base class for all power units of measure.
 *
 * Each concrete subclass represents a specific power unit (e.g. watts, horsepower)
 * and provides its conversion factor relative to the SI base unit (watt).
 *
 * @see Power for the quantity class that uses these units
 */
abstract readonly class PowerUnit extends UnitOfMeasure
{
}
