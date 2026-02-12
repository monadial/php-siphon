<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Brick\Math\BigDecimal;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Space\Area;
use Monadial\Siphon\Unit\Mechanics\Pressure\Atmospheres;
use Monadial\Siphon\Unit\Mechanics\Pressure\Bars;
use Monadial\Siphon\Unit\Mechanics\Pressure\Kilopascals;
use Monadial\Siphon\Unit\Mechanics\Pressure\Megapascals;
use Monadial\Siphon\Unit\Mechanics\Pressure\Millibars;
use Monadial\Siphon\Unit\Mechanics\Pressure\MillimetersOfMercury;
use Monadial\Siphon\Unit\Mechanics\Pressure\Pascals;
use Monadial\Siphon\Unit\Mechanics\Pressure\PoundsPerSquareInch;
use Monadial\Siphon\Unit\Mechanics\Pressure\Torr;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<PressureUnit>
 */
final readonly class Pressure extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function atmospheres(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Atmospheres::make());
    }

    public static function atmosphere(BigDecimal|int|float|string $value): self
    {
        return self::atmospheres($value);
    }

    public static function bars(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Bars::make());
    }

    public static function bar(BigDecimal|int|float|string $value): self
    {
        return self::bars($value);
    }

    public static function kilopascals(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kilopascals::make());
    }

    public static function kilopascal(BigDecimal|int|float|string $value): self
    {
        return self::kilopascals($value);
    }

    public static function megapascals(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Megapascals::make());
    }

    public static function megapascal(BigDecimal|int|float|string $value): self
    {
        return self::megapascals($value);
    }

    public static function millibars(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Millibars::make());
    }

    public static function millibar(BigDecimal|int|float|string $value): self
    {
        return self::millibars($value);
    }

    public static function millimetersOfMercury(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), MillimetersOfMercury::make());
    }

    public static function pascals(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Pascals::make());
    }

    public static function pascal(BigDecimal|int|float|string $value): self
    {
        return self::pascals($value);
    }

    public static function poundsPerSquareInch(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), PoundsPerSquareInch::make());
    }

    public static function torr(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Torr::make());
    }

    // END_TYPED_FACTORIES
    public function toPascals(): self
    {
        return $this->scaleTo(Pascals::make());
    }

    public function toKilopascals(): self
    {
        return $this->scaleTo(Kilopascals::make());
    }

    public function toMegapascals(): self
    {
        return $this->scaleTo(Megapascals::make());
    }

    public function toBars(): self
    {
        return $this->scaleTo(Bars::make());
    }

    public function toMillibars(): self
    {
        return $this->scaleTo(Millibars::make());
    }

    public function toAtmospheres(): self
    {
        return $this->scaleTo(Atmospheres::make());
    }

    public function toPoundsPerSquareInch(): self
    {
        return $this->scaleTo(PoundsPerSquareInch::make());
    }

    public function toTorr(): self
    {
        return $this->scaleTo(Torr::make());
    }

    public function toMillimetersOfMercury(): self
    {
        return $this->scaleTo(MillimetersOfMercury::make());
    }

    public function timesArea(Area $area): Force
    {
        $base = $this->toBaseValue()->multipliedBy($area->toBaseValue());
        return Force::newtons($base);
    }
}
