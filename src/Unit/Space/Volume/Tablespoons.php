<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\VolumeUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Tablespoons extends VolumeUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('0.00001478676478125');
    }
}
