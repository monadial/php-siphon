<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base for all electrical resistance units.
 *
 * Each concrete subclass defines its conversion {@see factor()} relative
 * to the SI base unit (ohm) and its display {@see symbol()}.
 *
 * @see ElectricalResistance
 */
abstract readonly class ElectricalResistanceUnit extends UnitOfMeasure
{
}
