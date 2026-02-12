<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\Information;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Information\InformationUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Kilobytes extends InformationUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }
}
