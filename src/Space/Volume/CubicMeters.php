<?php

declare(strict_types=1);

namespace Monadial\Siphon\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Space\VolumeUnit;
use Override;

final readonly class CubicMeters extends VolumeUnit
{
    #[Override]
    public function symbols(): ArrayList
    {
        return 'm³';
    }

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::one();
    }
}
