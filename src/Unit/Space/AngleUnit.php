<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base for all units of plane angle.
 *
 * Each concrete subclass provides a conversion factor relative to the SI unit
 * radian (rad). Conversion factors for angular units are derived from the
 * mathematical constant pi.
 *
 * @see Angle for the quantity class that uses these units.
 */
abstract readonly class AngleUnit extends UnitOfMeasure
{
}
