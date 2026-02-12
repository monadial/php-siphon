<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\SolidAngle;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\SolidAngleUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Steradians extends SolidAngleUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('1');
    }
}
