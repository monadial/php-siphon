<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Temperature\Temperature;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Temperature\TemperatureUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Celsius extends TemperatureUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::one();
    }

    #[Override]
    public function offset(): BigDecimal
    {
        return BigDecimal::of('273.15');
    }
}
