<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Motion;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base unit for velocity quantities.
 *
 * Concrete subclasses represent velocity units (MetersPerSecond, KilometersPerHour,
 * MilesPerHour, Knots, FeetPerSecond, etc.) and provide a conversion factor
 * relative to the base unit MetersPerSecond (factor 1).
 *
 * @see Velocity
 */
abstract readonly class VelocityUnit extends UnitOfMeasure
{
}
