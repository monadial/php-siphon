<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base class for all torque units of measure.
 *
 * Each concrete subclass represents a specific torque unit (e.g. newton meters, pound-feet)
 * and provides its conversion factor relative to the SI base unit (newton meter).
 *
 * @see Torque for the quantity class that uses these units
 */
abstract readonly class TorqueUnit extends UnitOfMeasure
{
}
