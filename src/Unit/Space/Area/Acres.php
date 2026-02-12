<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Area;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\AreaUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Acres extends AreaUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('4046.8564224');
    }
}
