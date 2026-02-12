<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Temperature\Temperature;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Temperature\TemperatureUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Rankine extends TemperatureUnit
{
    /**
     * Factor: 5/9 (conversion ratio from Rankine interval to Kelvin interval).
     */
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('0.55555555555555555556');
    }
}
