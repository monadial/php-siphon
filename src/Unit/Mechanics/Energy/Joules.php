<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Energy;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\EnergyUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Joules extends EnergyUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'J';
    }
}
