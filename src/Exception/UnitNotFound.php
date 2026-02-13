<?php

declare(strict_types=1);

namespace Monadial\Siphon\Exception;

/**
 * Thrown when a unit class cannot be resolved or discovered.
 *
 * Raised by {@see UnitOfMeasure::from()} when the Quantity class cannot
 * be inferred, or by {@see UnitRegistry} when no unit directory exists
 * for a given quantity class.
 *
 * @see SiphonError
 * @see \Monadial\Siphon\Parsing\UnitRegistry
 */
final class UnitNotFound extends SiphonError
{
}
