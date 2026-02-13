<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base for all electric charge units.
 *
 * Each concrete subclass defines its conversion {@see factor()} relative
 * to the SI base unit (coulomb) and its display {@see symbol()}.
 *
 * @see ElectricCharge
 */
abstract readonly class ElectricChargeUnit extends UnitOfMeasure
{
}
