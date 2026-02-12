<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Pressure;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\PressureUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Pascals extends PressureUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }
}
