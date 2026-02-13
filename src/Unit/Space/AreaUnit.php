<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base for all units of area.
 *
 * Each concrete subclass provides a conversion factor relative to the SI derived unit
 * square meter (m^2). Factors are typically the square of the corresponding length factor
 * or defined by convention (e.g. acres, hectares, barns).
 *
 * @see Area for the quantity class that uses these units.
 */
abstract readonly class AreaUnit extends UnitOfMeasure
{
}
