<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Substance;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base unit for amount of substance quantities.
 *
 * Concrete subclasses represent amount of substance units (Micromoles, Millimoles,
 * Moles, Kilomoles) and provide a conversion factor relative to the base unit
 * Moles (factor 1).
 *
 * @see AmountOfSubstance
 */
abstract readonly class AmountOfSubstanceUnit extends UnitOfMeasure
{
}
