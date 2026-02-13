<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base class for all mass flow rate units of measure.
 *
 * Each concrete subclass represents a specific mass flow unit (e.g. kg/s, lb/s)
 * and provides its conversion factor relative to the SI base unit (kilograms per second).
 *
 * @see MassFlow for the quantity class that uses these units
 */
abstract readonly class MassFlowUnit extends UnitOfMeasure
{
}
