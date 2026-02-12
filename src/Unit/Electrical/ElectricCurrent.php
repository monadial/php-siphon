<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Brick\Math\BigDecimal;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Time\Time;
use Monadial\Siphon\Unit\Electrical\ElectricCurrent\Amperes;
use Monadial\Siphon\Unit\Electrical\ElectricCurrent\Kiloamperes;
use Monadial\Siphon\Unit\Electrical\ElectricCurrent\Microamperes;
use Monadial\Siphon\Unit\Electrical\ElectricCurrent\Milliamperes;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<ElectricCurrentUnit>
 */
final readonly class ElectricCurrent extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function amperes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Amperes::make());
    }

    public static function ampere(BigDecimal|int|float|string $value): self
    {
        return self::amperes($value);
    }

    public static function kiloamperes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kiloamperes::make());
    }

    public static function kiloampere(BigDecimal|int|float|string $value): self
    {
        return self::kiloamperes($value);
    }

    public static function microamperes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Microamperes::make());
    }

    public static function microampere(BigDecimal|int|float|string $value): self
    {
        return self::microamperes($value);
    }

    public static function milliamperes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Milliamperes::make());
    }

    public static function milliampere(BigDecimal|int|float|string $value): self
    {
        return self::milliamperes($value);
    }

    // END_TYPED_FACTORIES
    public function toMicroamperes(): self
    {
        return $this->scaleTo(Microamperes::make());
    }

    public function toMilliamperes(): self
    {
        return $this->scaleTo(Milliamperes::make());
    }

    public function toAmperes(): self
    {
        return $this->scaleTo(Amperes::make());
    }

    public function toKiloamperes(): self
    {
        return $this->scaleTo(Kiloamperes::make());
    }

    // ---------------------------------------------------------------
    // Cross-dimensional operations
    // ---------------------------------------------------------------

    public function timesResistance(ElectricalResistance $resistance): ElectricPotential
    {
        $base = $this->toBaseValue()->multipliedBy($resistance->toBaseValue());
        return ElectricPotential::volts($base);
    }

    public function timesTime(Time $time): ElectricCharge
    {
        $base = $this->toBaseValue()->multipliedBy($time->toBaseValue());
        return ElectricCharge::coulombs($base);
    }
}
