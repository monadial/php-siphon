<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base for all inductance units.
 *
 * Each concrete subclass defines its conversion {@see factor()} relative
 * to the SI base unit (henry) and its display {@see symbol()}.
 *
 * @see Inductance
 */
abstract readonly class InductanceUnit extends UnitOfMeasure
{
}
