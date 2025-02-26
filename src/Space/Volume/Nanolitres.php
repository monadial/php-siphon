<?php

declare(strict_types=1);

namespace Monadial\Siphon\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\MetricSystem;
use Monadial\Siphon\Space\VolumeUnit;

final readonly class Nanolitres extends VolumeUnit
{
    public function symbols(): ArrayList
    {
        return 'nl';
    }

    public function factor(): BigDecimal
    {
        return Litres::make()
            ->factor()
            ->multipliedBy(MetricSystem::NANO->factor());
    }
}
