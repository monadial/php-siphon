<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\MassFlow;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\MassFlowUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class KilogramsPerHour extends MassFlowUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('0.00027777777777777778');
    }
}
