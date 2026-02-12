<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\SolidAngle;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\SolidAngleUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class SquareDegrees extends SolidAngleUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('0.00030461741978670860');
    }
}
