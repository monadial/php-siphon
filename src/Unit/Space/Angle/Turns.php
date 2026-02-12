<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Angle;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\AngleUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Turns extends AngleUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('6.28318530717958647693');
    }
}
