<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base unit for data transfer rate quantities.
 *
 * Concrete subclasses represent data throughput units in both bit-based
 * (BitsPerSecond, KilobitsPerSecond, etc.) and byte-based (BytesPerSecond,
 * KilobytesPerSecond, etc.) variants. Each provides a conversion factor
 * relative to the base unit BytesPerSecond (factor 1).
 *
 * @see DataRate
 */
abstract readonly class DataRateUnit extends UnitOfMeasure
{
}
