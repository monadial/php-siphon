<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mass;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base unit for mass quantities.
 *
 * Concrete subclasses represent mass units in both metric (Micrograms, Milligrams,
 * Grams, Kilograms, Tonnes) and imperial/customary (Ounces, Pounds, Stones) systems.
 * Each provides a conversion factor relative to the base unit Kilograms (factor 1).
 *
 * @see Mass
 */
abstract readonly class MassUnit extends UnitOfMeasure
{
}
