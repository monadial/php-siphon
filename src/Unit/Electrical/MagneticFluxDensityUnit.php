<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base for all magnetic flux density units.
 *
 * Each concrete subclass defines its conversion {@see factor()} relative
 * to the SI base unit (tesla) and its display {@see symbol()}.
 *
 * @see MagneticFluxDensity
 */
abstract readonly class MagneticFluxDensityUnit extends UnitOfMeasure
{
}
