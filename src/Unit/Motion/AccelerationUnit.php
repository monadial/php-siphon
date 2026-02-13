<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Motion;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base unit for acceleration quantities.
 *
 * Concrete subclasses represent acceleration units (MetersPerSecondSquared,
 * FeetPerSecondSquared, StandardGravity) and provide a conversion factor
 * relative to the base unit MetersPerSecondSquared (factor 1).
 *
 * @see Acceleration
 */
abstract readonly class AccelerationUnit extends UnitOfMeasure
{
}
