<?php

declare(strict_types=1);

namespace Monadial\Siphon\Space\Volume;

use Brick\Math\BigDecimal;
use Fp\Collections\ArrayList;
use Monadial\Siphon\MetricSystem;
use Monadial\Siphon\Space\VolumeUnit;

final readonly class Centilitres extends VolumeUnit
{
    public function symbols(): ArrayList
    {
        return ArrayList::singleton('cl');
    }

    public function factor(): BigDecimal
    {
        return Litres::make()
            ->factor()
            ->multipliedBy(MetricSystem::CENTI->factor());
    }
}
