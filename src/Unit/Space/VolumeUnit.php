<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base for all units of volume.
 *
 * Each concrete subclass provides a conversion factor relative to the SI derived unit
 * cubic meter (m^3). Includes metric-derived litres, imperial cubic measures, and
 * US customary cooking/liquid measures.
 *
 * @see Volume for the quantity class that uses these units.
 */
abstract readonly class VolumeUnit extends UnitOfMeasure
{
}
