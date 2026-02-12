<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\VolumeUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class UsPints extends VolumeUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('0.000473176473');
    }
}
