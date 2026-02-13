<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base for all units of length.
 *
 * Each concrete subclass provides a conversion factor relative to the SI base unit
 * meter (m). Metric units delegate to MetricSystem prefixes; imperial and astronomical
 * units define their own fixed conversion factors.
 *
 * @see Length for the quantity class that uses these units.
 */
abstract readonly class LengthUnit extends UnitOfMeasure
{
}
