<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\MassFlow;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\MassFlowUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class KilogramsPerSecond extends MassFlowUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }
}
