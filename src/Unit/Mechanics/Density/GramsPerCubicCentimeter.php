<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Density;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\DensityUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class GramsPerCubicCentimeter extends DensityUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('1000');
    }
}
