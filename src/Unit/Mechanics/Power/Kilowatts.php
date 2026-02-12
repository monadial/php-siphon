<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Power;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\PowerUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Kilowatts extends PowerUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }
}
