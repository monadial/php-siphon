<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\MassFlow;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\MassFlowUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class PoundsPerSecond extends MassFlowUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('0.45359237');
    }
}
