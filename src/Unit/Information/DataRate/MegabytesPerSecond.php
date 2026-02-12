<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\DataRate;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Information\DataRateUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class MegabytesPerSecond extends DataRateUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MEGA->factor();
    }
}
