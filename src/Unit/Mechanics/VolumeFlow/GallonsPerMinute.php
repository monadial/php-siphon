<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\VolumeFlow;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\VolumeFlowUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class GallonsPerMinute extends VolumeFlowUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('0.00006309019640000000');
    }
}
