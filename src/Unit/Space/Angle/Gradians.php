<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Angle;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\AngleUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Gradians extends AngleUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('0.01570796326794896619');
    }
}
