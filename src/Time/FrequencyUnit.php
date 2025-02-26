<?php

declare(strict_types=1);

namespace Monadial\Siphon\Time;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\UnitOfMeasure;
use Stringable;

abstract readonly class FrequencyUnit extends UnitOfMeasure
{
    public static function apply(BigDecimal $value): Quantity
    {
        // TODO: Implement apply() method.
    }

    public static function fromString(Stringable|string $value): Quantity
    {
        // TODO: Implement fromString() method.
    }

    public static function fromInt(int $value): Quantity
    {
        // TODO: Implement fromInt() method.
    }
}
