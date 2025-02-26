<?php

declare(strict_types=1);

namespace Monadial\Siphon\Space\Area;

use Brick\Math\BigDecimal;
use Monadial\Siphon\MetricSystem;
use Monadial\Siphon\Space\AreaUnit;
use Override;

final readonly class SquareMeters extends AreaUnit
{
    #[Override]
    public function symbols(): ArrayList
    {
        return 'm²';
    }

    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor()->power(2);
    }
}
