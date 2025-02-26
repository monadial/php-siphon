<?php

declare(strict_types=1);

namespace Monadial\Siphon\Time;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\UnitOfMeasure;

abstract readonly class TimeUnit extends UnitOfMeasure
{
    public static function apply(BigDecimal $value): Quantity
    {
        return new Time($value, new static());
    }
}
