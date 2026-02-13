<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Dimensionless;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base unit for dimensionless quantities.
 *
 * Concrete subclasses represent counting units (Each, Dozen, Score, Gross, Percent)
 * and provide a conversion factor relative to the base unit Each (factor 1).
 *
 * @see Dimensionless
 */
abstract readonly class DimensionlessUnit extends UnitOfMeasure
{
}
