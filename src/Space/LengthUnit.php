<?php

declare(strict_types=1);

namespace Monadial\Siphon\Space;

use Brick\Math\BigDecimal;
use Brick\Math\BigNumber;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\UnitOfMeasure;
use Override;

use Stringable;
use function Fp\Callable\ctor;

abstract readonly class LengthUnit extends UnitOfMeasure
{
    #[Override]
    public static function apply(BigNumber $value): Length
    {
        return ctor(Length::class)($value, static::make());
    }

    #[Override]
    public static function fromString(Stringable|string $value): Length
    {
        return self::apply(BigDecimal::of($value));
    }

    #[Override]
    public static function fromInt(int $value): Length
    {
        return self::apply(BigDecimal::of($value));
    }

    abstract public function factor(): BigDecimal;
}
