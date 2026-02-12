<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricPotential;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricPotentialUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Kilovolts extends ElectricPotentialUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }
}
