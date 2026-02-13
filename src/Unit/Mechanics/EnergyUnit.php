<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base class for all energy units of measure.
 *
 * Each concrete subclass represents a specific energy unit (e.g. joules, kilowatt-hours)
 * and provides its conversion factor relative to the SI base unit (joule).
 *
 * @see Energy for the quantity class that uses these units
 */
abstract readonly class EnergyUnit extends UnitOfMeasure
{
}
