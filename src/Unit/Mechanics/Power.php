<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Mechanics\Energy\WattHours;
use Monadial\Siphon\Unit\Time\Time;
use Monadial\Siphon\Unit\Mechanics\Power\BtusPerHour;
use Monadial\Siphon\Unit\Mechanics\Power\Gigawatts;
use Monadial\Siphon\Unit\Mechanics\Power\Horsepower;
use Monadial\Siphon\Unit\Mechanics\Power\Kilowatts;
use Monadial\Siphon\Unit\Mechanics\Power\Megawatts;
use Monadial\Siphon\Unit\Mechanics\Power\Milliwatts;
use Monadial\Siphon\Unit\Mechanics\Power\Watts;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<PowerUnit>
 */
final readonly class Power extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function btusPerHour(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), BtusPerHour::make());
    }

    public static function gigawatts(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Gigawatts::make());
    }

    public static function gigawatt(BigDecimal|int|float|string $value): self
    {
        return self::gigawatts($value);
    }

    public static function horsepower(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Horsepower::make());
    }

    public static function kilowatts(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kilowatts::make());
    }

    public static function kilowatt(BigDecimal|int|float|string $value): self
    {
        return self::kilowatts($value);
    }

    public static function megawatts(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Megawatts::make());
    }

    public static function megawatt(BigDecimal|int|float|string $value): self
    {
        return self::megawatts($value);
    }

    public static function milliwatts(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Milliwatts::make());
    }

    public static function milliwatt(BigDecimal|int|float|string $value): self
    {
        return self::milliwatts($value);
    }

    public static function watts(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Watts::make());
    }

    public static function watt(BigDecimal|int|float|string $value): self
    {
        return self::watts($value);
    }

    // END_TYPED_FACTORIES
    /**
     * @param BigDecimal|int|float|string $hours
     */
    public function toWattHours(BigDecimal|int|float|string $hours = 1): Energy
    {
        return new Energy(
            $this->toWatts()->value()->multipliedBy(BigDecimal::of($hours)),
            WattHours::make(),
        );
    }

    public function toWatts(): self
    {
        return $this->scaleTo(Watts::make());
    }

    public function toMilliwatts(): self
    {
        return $this->scaleTo(Milliwatts::make());
    }

    public function toKilowatts(): self
    {
        return $this->scaleTo(Kilowatts::make());
    }

    public function toMegawatts(): self
    {
        return $this->scaleTo(Megawatts::make());
    }

    public function toGigawatts(): self
    {
        return $this->scaleTo(Gigawatts::make());
    }

    public function toHorsepower(): self
    {
        return $this->scaleTo(Horsepower::make());
    }

    public function toBtusPerHour(): self
    {
        return $this->scaleTo(BtusPerHour::make());
    }

    /**
     * @psalm-suppress ImpureMethodCall
     */
    public function timesTime(Time $time): Energy
    {
        $base = $this->toBaseValue()->multipliedBy($time->toBaseValue());
        return Energy::joules($base);
    }
}
