<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Motion\Velocity;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Motion\VelocityUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Knots extends VelocityUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('0.51444444444444444444');
    }

    #[Override]
    public function symbol(): string
    {
        return 'kn';
    }
}
