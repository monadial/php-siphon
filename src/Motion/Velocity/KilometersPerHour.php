<?php

declare(strict_types=1);

namespace Monadial\Siphon\Motion\Velocity;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Motion\VelocityUnit;
use Monadial\Siphon\Space\Length\Kilometers;
use Monadial\Siphon\Space\Length\Meters;

final readonly class KilometersPerHour extends VelocityUnit
{
    public function symbols(): ArrayList
    {
        return 'km/h';
    }

    public function factor(): BigDecimal
    {
        return Kilometers::make()
            ->factor()
            ->dividedBy(Meters::make()->factor())
            ->dividedBy()
    }
}
