<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Brick\Math\BigDecimal;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Mechanics\Momentum\KilogramMetersPerSecond;
use Monadial\Siphon\Unit\Mechanics\Momentum\NewtonSeconds;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<MomentumUnit>
 */
final readonly class Momentum extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function kilogramMetersPerSecond(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), KilogramMetersPerSecond::make());
    }

    public static function newtonSeconds(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), NewtonSeconds::make());
    }

    public static function newtonSecond(BigDecimal|int|float|string $value): self
    {
        return self::newtonSeconds($value);
    }

    // END_TYPED_FACTORIES
    public function toNewtonSeconds(): self
    {
        return $this->scaleTo(NewtonSeconds::make());
    }

    public function toKilogramMetersPerSecond(): self
    {
        return $this->scaleTo(KilogramMetersPerSecond::make());
    }
}
