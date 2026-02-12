<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Motion\Velocity;
use Monadial\Siphon\Unit\Space\Length\AstronomicalUnits;
use Monadial\Siphon\Unit\Space\Length\Centimeters;
use Monadial\Siphon\Unit\Space\Length\Decameters;
use Monadial\Siphon\Unit\Space\Length\Decimeters;
use Monadial\Siphon\Unit\Space\Length\Feet;
use Monadial\Siphon\Unit\Space\Length\Hectometers;
use Monadial\Siphon\Unit\Space\Length\Inches;
use Monadial\Siphon\Unit\Space\Length\Kilometers;
use Monadial\Siphon\Unit\Space\Length\LightYears;
use Monadial\Siphon\Unit\Space\Length\Meters;
use Monadial\Siphon\Unit\Space\Length\Micrometers;
use Monadial\Siphon\Unit\Space\Length\Miles;
use Monadial\Siphon\Unit\Space\Length\Millimeters;
use Monadial\Siphon\Unit\Space\Length\Nanometers;
use Monadial\Siphon\Unit\Space\Length\NauticalMiles;
use Monadial\Siphon\Unit\Space\Length\Yards;
use Monadial\Siphon\Unit\Space\Volume\CubicMeters;
use Monadial\Siphon\Unit\Time\Time;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<LengthUnit>
 */
final readonly class Length extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function astronomicalUnits(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), AstronomicalUnits::make());
    }

    public static function astronomicalUnit(BigDecimal|int|float|string $value): self
    {
        return self::astronomicalUnits($value);
    }

    public static function centimeters(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Centimeters::make());
    }

    public static function centimeter(BigDecimal|int|float|string $value): self
    {
        return self::centimeters($value);
    }

    public static function decameters(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Decameters::make());
    }

    public static function decameter(BigDecimal|int|float|string $value): self
    {
        return self::decameters($value);
    }

    public static function decimeters(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Decimeters::make());
    }

    public static function decimeter(BigDecimal|int|float|string $value): self
    {
        return self::decimeters($value);
    }

    public static function feet(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Feet::make());
    }

    public static function foot(BigDecimal|int|float|string $value): self
    {
        return self::feet($value);
    }

    public static function hectometers(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Hectometers::make());
    }

    public static function hectometer(BigDecimal|int|float|string $value): self
    {
        return self::hectometers($value);
    }

    public static function inches(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Inches::make());
    }

    public static function inch(BigDecimal|int|float|string $value): self
    {
        return self::inches($value);
    }

    public static function kilometers(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kilometers::make());
    }

    public static function kilometer(BigDecimal|int|float|string $value): self
    {
        return self::kilometers($value);
    }

    public static function lightYears(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), LightYears::make());
    }

    public static function lightYear(BigDecimal|int|float|string $value): self
    {
        return self::lightYears($value);
    }

    public static function meters(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Meters::make());
    }

    public static function meter(BigDecimal|int|float|string $value): self
    {
        return self::meters($value);
    }

    public static function micrometers(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Micrometers::make());
    }

    public static function micrometer(BigDecimal|int|float|string $value): self
    {
        return self::micrometers($value);
    }

    public static function miles(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Miles::make());
    }

    public static function mile(BigDecimal|int|float|string $value): self
    {
        return self::miles($value);
    }

    public static function millimeters(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Millimeters::make());
    }

    public static function millimeter(BigDecimal|int|float|string $value): self
    {
        return self::millimeters($value);
    }

    public static function nanometers(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Nanometers::make());
    }

    public static function nanometer(BigDecimal|int|float|string $value): self
    {
        return self::nanometers($value);
    }

    public static function nauticalMiles(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), NauticalMiles::make());
    }

    public static function nauticalMile(BigDecimal|int|float|string $value): self
    {
        return self::nauticalMiles($value);
    }

    public static function yards(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Yards::make());
    }

    public static function yard(BigDecimal|int|float|string $value): self
    {
        return self::yards($value);
    }

    // END_TYPED_FACTORIES
    /**
     * Convenience conversion from a one-dimensional length to a cubic volume (m^3),
     * assuming a cube with equal edge lengths.
     */
    public function toCubic(): Volume
    {
        $meters = $this->toMeters()->value();

        return new Volume($meters->power(3), CubicMeters::make());
    }

    public function cubed(): Volume
    {
        return $this->toCubic();
    }

    public function toNanometers(): self
    {
        return $this->scaleTo(Nanometers::make());
    }

    public function toMicrometers(): self
    {
        return $this->scaleTo(Micrometers::make());
    }

    public function toMillimeters(): self
    {
        return $this->scaleTo(Millimeters::make());
    }

    public function toCentimeters(): self
    {
        return $this->scaleTo(Centimeters::make());
    }

    public function toDecimeters(): self
    {
        return $this->scaleTo(Decimeters::make());
    }

    public function toMeters(): self
    {
        return $this->scaleTo(Meters::make());
    }

    public function toDecameters(): self
    {
        return $this->scaleTo(Decameters::make());
    }

    public function toHectometers(): self
    {
        return $this->scaleTo(Hectometers::make());
    }

    public function toKilometers(): self
    {
        return $this->scaleTo(Kilometers::make());
    }

    public function toInches(): self
    {
        return $this->scaleTo(Inches::make());
    }

    public function toFeet(): self
    {
        return $this->scaleTo(Feet::make());
    }

    public function toYards(): self
    {
        return $this->scaleTo(Yards::make());
    }

    public function toMiles(): self
    {
        return $this->scaleTo(Miles::make());
    }

    public function toNauticalMiles(): self
    {
        return $this->scaleTo(NauticalMiles::make());
    }

    public function toAstronomicalUnits(): self
    {
        return $this->scaleTo(AstronomicalUnits::make());
    }

    public function toLightYears(): self
    {
        return $this->scaleTo(LightYears::make());
    }

    // ---------------------------------------------------------------
    // Cross-dimensional operations
    // ---------------------------------------------------------------

    /**
     * @psalm-suppress ImpureMethodCall
     */
    public function timesLength(Length $that): Area
    {
        $base = $this->toBaseValue()->multipliedBy($that->toBaseValue());
        return Area::squareMeters($base);
    }

    /**
     * @psalm-suppress ImpureMethodCall
     */
    public function timesArea(Area $that): Volume
    {
        $base = $this->toBaseValue()->multipliedBy($that->toBaseValue());
        return Volume::cubicMeters($base);
    }

    /**
     * @psalm-suppress ImpureMethodCall
     */
    public function dividedByTime(Time $that): Velocity
    {
        $base = $this->toBaseValue()->dividedBy($that->toBaseValue(), 20, RoundingMode::HALF_UP);
        return Velocity::metersPerSecond($base);
    }
}
