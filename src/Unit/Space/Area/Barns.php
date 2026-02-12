<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Area;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\AreaUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Barns extends AreaUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('0.0000000000000000000000000001');
    }
}
