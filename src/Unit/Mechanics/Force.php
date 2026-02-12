<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Motion\Velocity;
use Monadial\Siphon\Unit\Space\Area;
use Monadial\Siphon\Unit\Space\Length;
use Monadial\Siphon\Unit\Mechanics\Force\Dynes;
use Monadial\Siphon\Unit\Mechanics\Force\KilogramForce;
use Monadial\Siphon\Unit\Mechanics\Force\Kilonewtons;
use Monadial\Siphon\Unit\Mechanics\Force\Meganewtons;
use Monadial\Siphon\Unit\Mechanics\Force\Millinewtons;
use Monadial\Siphon\Unit\Mechanics\Force\Newtons;
use Monadial\Siphon\Unit\Mechanics\Force\PoundForce;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<ForceUnit>
 */
final readonly class Force extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function dynes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Dynes::make());
    }

    public static function dyne(BigDecimal|int|float|string $value): self
    {
        return self::dynes($value);
    }

    public static function kilogramForce(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), KilogramForce::make());
    }

    public static function kilonewtons(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kilonewtons::make());
    }

    public static function kilonewton(BigDecimal|int|float|string $value): self
    {
        return self::kilonewtons($value);
    }

    public static function meganewtons(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Meganewtons::make());
    }

    public static function meganewton(BigDecimal|int|float|string $value): self
    {
        return self::meganewtons($value);
    }

    public static function millinewtons(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Millinewtons::make());
    }

    public static function millinewton(BigDecimal|int|float|string $value): self
    {
        return self::millinewtons($value);
    }

    public static function newtons(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Newtons::make());
    }

    public static function newton(BigDecimal|int|float|string $value): self
    {
        return self::newtons($value);
    }

    public static function poundForce(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), PoundForce::make());
    }

    // END_TYPED_FACTORIES
    public function toNewtons(): self
    {
        return $this->scaleTo(Newtons::make());
    }

    public function toKilonewtons(): self
    {
        return $this->scaleTo(Kilonewtons::make());
    }

    public function toMeganewtons(): self
    {
        return $this->scaleTo(Meganewtons::make());
    }

    public function toMillinewtons(): self
    {
        return $this->scaleTo(Millinewtons::make());
    }

    public function toDynes(): self
    {
        return $this->scaleTo(Dynes::make());
    }

    public function toPoundForce(): self
    {
        return $this->scaleTo(PoundForce::make());
    }

    public function toKilogramForce(): self
    {
        return $this->scaleTo(KilogramForce::make());
    }

    /**
     * @psalm-suppress ImpureMethodCall
     */
    public function timesLength(Length $length): Energy
    {
        $base = $this->toBaseValue()->multipliedBy($length->toBaseValue());
        return Energy::joules($base);
    }

    /**
     * @psalm-suppress ImpureMethodCall
     */
    public function timesVelocity(Velocity $velocity): Power
    {
        $base = $this->toBaseValue()->multipliedBy($velocity->toBaseValue());
        return Power::watts($base);
    }

    /**
     * @psalm-suppress ImpureMethodCall
     */
    public function dividedByArea(Area $area): Pressure
    {
        $base = $this->toBaseValue()->dividedBy($area->toBaseValue(), 20, RoundingMode::HALF_UP);
        return Pressure::pascals($base);
    }
}
