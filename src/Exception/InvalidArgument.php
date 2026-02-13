<?php

declare(strict_types=1);

namespace Monadial\Siphon\Exception;

/**
 * Thrown when a method receives an argument that violates its contract.
 *
 * Examples: negative or zero exchange rates, currency mismatches in
 * monetary conversions, or out-of-range numeric values.
 *
 * @see SiphonError
 */
final class InvalidArgument extends SiphonError
{
}
