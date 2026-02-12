<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\Inductance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\InductanceUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Henrys extends InductanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }
}
