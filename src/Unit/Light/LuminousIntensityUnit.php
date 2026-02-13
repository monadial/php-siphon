<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Light;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base unit for luminous intensity quantities.
 *
 * Concrete subclasses represent luminous intensity units (Millicandelas, Candelas,
 * Kilocandelas) and provide a conversion factor relative to the base unit
 * Candelas (factor 1).
 *
 * @see LuminousIntensity
 */
abstract readonly class LuminousIntensityUnit extends UnitOfMeasure
{
}
