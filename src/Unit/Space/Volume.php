<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Mechanics\VolumeFlow;
use Monadial\Siphon\Unit\Space\Volume\Centilitres;
use Monadial\Siphon\Unit\Space\Volume\CubicCentimeters;
use Monadial\Siphon\Unit\Space\Volume\CubicFeet;
use Monadial\Siphon\Unit\Space\Volume\CubicInches;
use Monadial\Siphon\Unit\Space\Volume\CubicMeters;
use Monadial\Siphon\Unit\Space\Volume\CubicYards;
use Monadial\Siphon\Unit\Space\Volume\Decilitres;
use Monadial\Siphon\Unit\Space\Volume\FluidOunces;
use Monadial\Siphon\Unit\Space\Volume\Hectolitres;
use Monadial\Siphon\Unit\Space\Volume\ImperialGallons;
use Monadial\Siphon\Unit\Space\Volume\Litres;
use Monadial\Siphon\Unit\Space\Volume\Millilitres;
use Monadial\Siphon\Unit\Space\Volume\Tablespoons;
use Monadial\Siphon\Unit\Space\Volume\Teaspoons;
use Monadial\Siphon\Unit\Space\Volume\UsCups;
use Monadial\Siphon\Unit\Space\Volume\UsGallons;
use Monadial\Siphon\Unit\Space\Volume\UsPints;
use Monadial\Siphon\Unit\Space\Volume\UsQuarts;
use Monadial\Siphon\Unit\Time\Time;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<VolumeUnit>
 */
final readonly class Volume extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function centilitres(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Centilitres::make());
    }

    public static function centilitre(BigDecimal|int|float|string $value): self
    {
        return self::centilitres($value);
    }

    public static function cubicCentimeters(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), CubicCentimeters::make());
    }

    public static function cubicCentimeter(BigDecimal|int|float|string $value): self
    {
        return self::cubicCentimeters($value);
    }

    public static function cubicFeet(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), CubicFeet::make());
    }

    public static function cubicInches(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), CubicInches::make());
    }

    public static function cubicInch(BigDecimal|int|float|string $value): self
    {
        return self::cubicInches($value);
    }

    public static function cubicMeters(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), CubicMeters::make());
    }

    public static function cubicMeter(BigDecimal|int|float|string $value): self
    {
        return self::cubicMeters($value);
    }

    public static function cubicYards(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), CubicYards::make());
    }

    public static function cubicYard(BigDecimal|int|float|string $value): self
    {
        return self::cubicYards($value);
    }

    public static function decilitres(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Decilitres::make());
    }

    public static function decilitre(BigDecimal|int|float|string $value): self
    {
        return self::decilitres($value);
    }

    public static function fluidOunces(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), FluidOunces::make());
    }

    public static function fluidOunce(BigDecimal|int|float|string $value): self
    {
        return self::fluidOunces($value);
    }

    public static function hectolitres(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Hectolitres::make());
    }

    public static function hectolitre(BigDecimal|int|float|string $value): self
    {
        return self::hectolitres($value);
    }

    public static function imperialGallons(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), ImperialGallons::make());
    }

    public static function imperialGallon(BigDecimal|int|float|string $value): self
    {
        return self::imperialGallons($value);
    }

    public static function litres(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Litres::make());
    }

    public static function litre(BigDecimal|int|float|string $value): self
    {
        return self::litres($value);
    }

    public static function millilitres(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Millilitres::make());
    }

    public static function millilitre(BigDecimal|int|float|string $value): self
    {
        return self::millilitres($value);
    }

    public static function tablespoons(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Tablespoons::make());
    }

    public static function tablespoon(BigDecimal|int|float|string $value): self
    {
        return self::tablespoons($value);
    }

    public static function teaspoons(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Teaspoons::make());
    }

    public static function teaspoon(BigDecimal|int|float|string $value): self
    {
        return self::teaspoons($value);
    }

    public static function usCups(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), UsCups::make());
    }

    public static function usCup(BigDecimal|int|float|string $value): self
    {
        return self::usCups($value);
    }

    public static function usGallons(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), UsGallons::make());
    }

    public static function usGallon(BigDecimal|int|float|string $value): self
    {
        return self::usGallons($value);
    }

    public static function usPints(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), UsPints::make());
    }

    public static function usPint(BigDecimal|int|float|string $value): self
    {
        return self::usPints($value);
    }

    public static function usQuarts(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), UsQuarts::make());
    }

    public static function usQuart(BigDecimal|int|float|string $value): self
    {
        return self::usQuarts($value);
    }

    // END_TYPED_FACTORIES
    public function toCubicCentimeters(): self
    {
        return $this->scaleTo(CubicCentimeters::make());
    }

    public function toCubicMeters(): self
    {
        return $this->scaleTo(CubicMeters::make());
    }

    public function toMillilitres(): self
    {
        return $this->scaleTo(Millilitres::make());
    }

    public function toCentilitres(): self
    {
        return $this->scaleTo(Centilitres::make());
    }

    public function toDecilitres(): self
    {
        return $this->scaleTo(Decilitres::make());
    }

    public function toLitres(): self
    {
        return $this->scaleTo(Litres::make());
    }

    public function toHectolitres(): self
    {
        return $this->scaleTo(Hectolitres::make());
    }

    public function toCubicInches(): self
    {
        return $this->scaleTo(CubicInches::make());
    }

    public function toCubicFeet(): self
    {
        return $this->scaleTo(CubicFeet::make());
    }

    public function toCubicYards(): self
    {
        return $this->scaleTo(CubicYards::make());
    }

    public function toUsGallons(): self
    {
        return $this->scaleTo(UsGallons::make());
    }

    public function toUsPints(): self
    {
        return $this->scaleTo(UsPints::make());
    }

    public function toUsQuarts(): self
    {
        return $this->scaleTo(UsQuarts::make());
    }

    public function toUsCups(): self
    {
        return $this->scaleTo(UsCups::make());
    }

    public function toFluidOunces(): self
    {
        return $this->scaleTo(FluidOunces::make());
    }

    public function toTablespoons(): self
    {
        return $this->scaleTo(Tablespoons::make());
    }

    public function toTeaspoons(): self
    {
        return $this->scaleTo(Teaspoons::make());
    }

    public function toImperialGallons(): self
    {
        return $this->scaleTo(ImperialGallons::make());
    }

    // ---------------------------------------------------------------
    // Cross-dimensional operations
    // ---------------------------------------------------------------

    /**
     * @psalm-suppress ImpureMethodCall
     */
    public function dividedByTime(Time $time): VolumeFlow
    {
        $base = $this->toBaseValue()->dividedBy($time->toBaseValue(), 20, RoundingMode::HALF_UP);
        return VolumeFlow::cubicMetersPerSecond($base);
    }
}
