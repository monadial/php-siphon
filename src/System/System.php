<?php

declare(strict_types=1);

namespace Monadial\Siphon\System;

use Brick\Math\BigNumber;

/**
 * Contract for unit system multipliers.
 *
 * Implementors define a {@see factor()} that returns the numeric multiplier
 * for a given prefix or tier within a unit system. This abstraction allows
 * both the decimal SI prefixes ({@see MetricSystem}) and the binary IEC
 * prefixes ({@see BinarySystem}) to be used interchangeably by concrete
 * unit classes.
 *
 * @see MetricSystem SI decimal prefixes (kilo, mega, giga, etc.)
 * @see BinarySystem IEC binary prefixes (kibi, mebi, gibi, etc.)
 */
interface System
{
    public function factor(): BigNumber;
}
