<?php

declare(strict_types=1);

namespace Monadial\Siphon\Space\Area;

use Brick\Math\BigDecimal;
use Monadial\Siphon\MetricSystem;
use Monadial\Siphon\Space\AreaUnit;
use Override;

final readonly class SquareCentimeters extends AreaUnit
{
    #[Override]
    public function symbols(): ArrayList
    {
        return 'cm²';
    }

    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::CENTI->factor()->power(2);
    }
}
