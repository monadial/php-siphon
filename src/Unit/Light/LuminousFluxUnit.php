<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Light;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base unit for luminous flux quantities.
 *
 * Concrete subclasses represent luminous flux units (Millilumens, Lumens, Kilolumens)
 * and provide a conversion factor relative to the base unit Lumens (factor 1).
 *
 * @see LuminousFlux
 */
abstract readonly class LuminousFluxUnit extends UnitOfMeasure
{
}
