<?php

declare(strict_types=1);

namespace Monadial\Siphon\Space\Area;

use Brick\Math\BigDecimal;
use Monadial\Siphon\MetricSystem;
use Monadial\Siphon\Space\AreaUnit;
use Override;

final readonly class SquareKilometers extends AreaUnit
{
    #[Override]
    public function symbols(): ArrayList
    {
        return 'km²';
    }

    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor()->power(2);
    }
}
