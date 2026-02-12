<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Dimensionless\Dimensionless;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Dimensionless\DimensionlessUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Each extends DimensionlessUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('1');
    }
}
