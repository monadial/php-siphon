<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base class for all force units of measure.
 *
 * Each concrete subclass represents a specific force unit (e.g. newtons, pound-force)
 * and provides its conversion factor relative to the SI base unit (newton).
 *
 * @see Force for the quantity class that uses these units
 */
abstract readonly class ForceUnit extends UnitOfMeasure
{
}
