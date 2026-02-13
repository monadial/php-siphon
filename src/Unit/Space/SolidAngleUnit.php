<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base for all units of solid angle.
 *
 * Each concrete subclass provides a conversion factor relative to the SI unit
 * steradian (sr). Solid angle measures the two-dimensional extent of an object
 * as seen from a point in three-dimensional space.
 *
 * @see SolidAngle for the quantity class that uses these units.
 */
abstract readonly class SolidAngleUnit extends UnitOfMeasure
{
}
