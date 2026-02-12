<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\VolumeFlow;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\VolumeFlowUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class LitresPerMinute extends VolumeFlowUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('0.00001666666666666667');
    }
}
