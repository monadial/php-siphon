<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Torque;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\TorqueUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class PoundFeet extends TorqueUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('1.3558179483314004');
    }
}
