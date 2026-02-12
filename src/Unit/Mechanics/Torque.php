<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Brick\Math\BigDecimal;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Mechanics\Torque\NewtonMeters;
use Monadial\Siphon\Unit\Mechanics\Torque\PoundFeet;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<TorqueUnit>
 */
final readonly class Torque extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function newtonMeters(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), NewtonMeters::make());
    }

    public static function newtonMeter(BigDecimal|int|float|string $value): self
    {
        return self::newtonMeters($value);
    }

    public static function poundFeet(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), PoundFeet::make());
    }

    // END_TYPED_FACTORIES
    public function toNewtonMeters(): self
    {
        return $this->scaleTo(NewtonMeters::make());
    }

    public function toPoundFeet(): self
    {
        return $this->scaleTo(PoundFeet::make());
    }
}
