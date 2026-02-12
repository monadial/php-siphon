<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Motion\Velocity;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Motion\VelocityUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class MilesPerHour extends VelocityUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('0.44704');
    }

    #[Override]
    public function symbol(): string
    {
        return 'mph';
    }
}
