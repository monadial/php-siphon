<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mass\Mass;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mass\MassUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Kilograms extends MassUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }
}
