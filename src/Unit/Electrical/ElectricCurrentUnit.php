<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base for all electric current units.
 *
 * Each concrete subclass defines its conversion {@see factor()} relative
 * to the SI base unit (ampere) and its display {@see symbol()}.
 *
 * @see ElectricCurrent
 */
abstract readonly class ElectricCurrentUnit extends UnitOfMeasure
{
}
