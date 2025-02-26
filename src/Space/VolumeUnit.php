<?php

declare(strict_types=1);

namespace Monadial\Siphon\Space;

use Brick\Math\BigDecimal;
use Brick\Math\BigNumber;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\UnitOfMeasure;
use Stringable;
use function Fp\Callable\ctor;

abstract readonly class VolumeUnit extends UnitOfMeasure
{
    public static function apply(BigDecimal $value): Quantity
    {
        return ctor(Volume::class)($value, static::make());
    }

    public static function fromString(Stringable|string $value): Quantity
    {
        return self::apply(BigDecimal::of($value));
    }

    public static function fromInt(int $value): Quantity
    {
        return self::apply(BigDecimal::of($value));
    }

}
