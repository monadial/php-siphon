<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\Information;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Information\InformationUnit;
use Override;

/**
 * The smallest unit of digital information, representing a single binary digit.
 *
 * Symbol: b. Conversion factor: 0.125 (1 bit = 1/8 byte).
 * A bit can hold one of two values: 0 or 1. Eight bits compose one byte.
 *
 * @see Bits::make()
 */
final readonly class Bits extends InformationUnit
{
    private const float FACTOR = 0.125;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'b';
    }
}
