<?php

declare(strict_types=1);

namespace Monadial\Siphon\Space\Length;

use Brick\Math\BigDecimal;
use Fp\Collections\ArrayList;
use Monadial\Siphon\MetricSystem;
use Monadial\Siphon\Space\LengthUnit;
use Override;

final readonly class Kilometers extends LengthUnit
{
    #[Override]
    public function symbols(): ArrayList
    {
        return ArrayList::singleton('km');
    }

    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }
}
