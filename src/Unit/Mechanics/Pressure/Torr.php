<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Pressure;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\PressureUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Torr extends PressureUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('133.32236842105263158');
    }
}
