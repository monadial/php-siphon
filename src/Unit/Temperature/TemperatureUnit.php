<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Temperature;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base unit for temperature quantities.
 *
 * Concrete subclasses represent temperature units (Millikelvins, Kelvins, Kilokelvins,
 * Celsius, Fahrenheit, Rankine). Temperature units may override both factor() and
 * offset() to handle non-absolute scales. Conversion factors are relative to the
 * base unit Kelvins (factor 1).
 *
 * @see Temperature
 */
abstract readonly class TemperatureUnit extends UnitOfMeasure
{
}
