<?php

declare(strict_types=1);

namespace Monadial\Siphon\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\MetricSystem;
use Monadial\Siphon\Space\VolumeUnit;

final readonly class Litres extends VolumeUnit
{
    public function symbols(): ArrayList
    {
        return 'L';
    }

    public function factor(): BigDecimal
    {
        return CubicMeters::make()
            ->factor()
            ->dividedBy(MetricSystem::MILLI->factor());
    }
}
