<?php

declare(strict_types=1);

namespace Monadial\Siphon\Exception;

/**
 * Thrown when a string cannot be parsed into a domain object.
 *
 * Raised by {@see Quantity::parse()} and {@see Money::parse()} when the
 * input string does not match the expected format (e.g., "not a quantity").
 *
 * @see SiphonError
 * @see \Monadial\Siphon\Parsing\QuantityParser
 */
final class ParseFailure extends SiphonError
{
}
