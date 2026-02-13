<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base class for all density units of measure.
 *
 * Each concrete subclass represents a specific density unit (e.g. kg/m^3, g/cm^3)
 * and provides its conversion factor relative to the SI base unit (kilograms per cubic meter).
 *
 * @see Density for the quantity class that uses these units
 */
abstract readonly class DensityUnit extends UnitOfMeasure
{
}
