<?php

declare(strict_types=1);

namespace Monadial\Siphon\Motion;

use Brick\Math\BigDecimal;
use Monadial\Siphon\UnitOfMeasure;

abstract readonly class VelocityUnit extends UnitOfMeasure
{
    public static function apply(BigDecimal $value): Velocity
    {
        return new Velocity($value, new static());
    }
}
