<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base for all electric potential (voltage) units.
 *
 * Each concrete subclass defines its conversion {@see factor()} relative
 * to the SI base unit (volt) and its display {@see symbol()}.
 *
 * @see ElectricPotential
 */
abstract readonly class ElectricPotentialUnit extends UnitOfMeasure
{
}
