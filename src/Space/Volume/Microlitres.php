<?php

declare(strict_types=1);

namespace Monadial\Siphon\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\MetricSystem;

final readonly class Microlitres extends VolumeUnit
{
    public function symbol(): string
    {
        return 'µl';
    }

    public function factor(): BigDecimal
    {
        return Litres::make()
            ->factor()
            ->multipliedBy(MetricSystem::MICRO->factor());
    }
}
