<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricCurrent;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricCurrentUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Microamperes extends ElectricCurrentUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MICRO->factor();
    }
}
