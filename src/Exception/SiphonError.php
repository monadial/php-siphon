<?php

declare(strict_types=1);

namespace Monadial\Siphon\Exception;

use LogicException;

/**
 * Base checked exception for the Siphon library.
 *
 * All domain-specific exceptions extend this class, enabling PHPStan's
 * checked exception analysis ({@see phpstan.neon}) to enforce that callers
 * either catch or declare these exceptions in their `@throws` annotations.
 *
 * Extends {@see LogicException} because Siphon errors represent programming
 * mistakes (invalid arguments, unknown units) rather than runtime failures.
 *
 * @see InvalidArgument Thrown for invalid method arguments.
 * @see ParseFailure Thrown when string parsing fails.
 * @see UnitNotFound Thrown when a unit class cannot be resolved.
 */
abstract class SiphonError extends LogicException
{
}
