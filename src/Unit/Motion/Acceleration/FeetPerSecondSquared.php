<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Motion\Acceleration;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Motion\AccelerationUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class FeetPerSecondSquared extends AccelerationUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('0.3048');
    }
}
