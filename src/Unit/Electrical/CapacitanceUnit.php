<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base for all capacitance units.
 *
 * Each concrete subclass defines its conversion {@see factor()} relative
 * to the SI base unit (farad) and its display {@see symbol()}.
 *
 * @see Capacitance
 */
abstract readonly class CapacitanceUnit extends UnitOfMeasure
{
}
