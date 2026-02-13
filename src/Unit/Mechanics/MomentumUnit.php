<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base class for all momentum units of measure.
 *
 * Each concrete subclass represents a specific momentum unit (e.g. kg*m/s, N*s)
 * and provides its conversion factor relative to the SI base unit (kilogram meter per second).
 *
 * @see Momentum for the quantity class that uses these units
 */
abstract readonly class MomentumUnit extends UnitOfMeasure
{
}
