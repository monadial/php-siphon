<?php

declare(strict_types=1);

namespace Monadial\Siphon\Time\Frequency;

use Brick\Math\BigDecimal;
use Fp\Collections\ArrayList;
use Monadial\Siphon\MetricSystem;
use Monadial\Siphon\Time\FrequencyUnit;

final readonly class Megahertz extends FrequencyUnit
{
    public function symbols(): ArrayList
    {
        return ArrayList::singleton(['MHz']);
    }

    public function factor(): BigDecimal
    {
        return MetricSystem::MEGA->factor();
    }
}
