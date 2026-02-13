<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base for all magnetic flux units.
 *
 * Each concrete subclass defines its conversion {@see factor()} relative
 * to the SI base unit (weber) and its display {@see symbol()}.
 *
 * @see MagneticFlux
 */
abstract readonly class MagneticFluxUnit extends UnitOfMeasure
{
}
