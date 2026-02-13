<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base for all electrical conductance units.
 *
 * Each concrete subclass defines its conversion {@see factor()} relative
 * to the SI base unit (siemens) and its display {@see symbol()}.
 *
 * @see ElectricalConductance
 */
abstract readonly class ElectricalConductanceUnit extends UnitOfMeasure
{
}
