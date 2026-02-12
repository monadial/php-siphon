<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Force;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\ForceUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Millinewtons extends ForceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MILLI->factor();
    }
}
