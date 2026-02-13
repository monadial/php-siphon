<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information;

use Monadial\Siphon\UnitOfMeasure;

/**
 * Abstract base unit for digital information quantities.
 *
 * Concrete subclasses represent data size units in both SI decimal (Bytes, Kilobytes,
 * Megabytes, etc.) and IEC binary (Kibibytes, Mebibytes, Gibibytes, etc.) prefixes.
 * Each provides a conversion factor relative to the base unit Bytes (factor 1).
 *
 * @see Information
 */
abstract readonly class InformationUnit extends UnitOfMeasure
{
}
