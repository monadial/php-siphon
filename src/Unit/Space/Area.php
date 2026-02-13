<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Space\Area\Acres;
use Monadial\Siphon\Unit\Space\Area\Barns;
use Monadial\Siphon\Unit\Space\Area\Hectares;
use Monadial\Siphon\Unit\Space\Area\SquareCentimeters;
use Monadial\Siphon\Unit\Space\Area\SquareFeet;
use Monadial\Siphon\Unit\Space\Area\SquareInches;
use Monadial\Siphon\Unit\Space\Area\SquareKilometers;
use Monadial\Siphon\Unit\Space\Area\SquareMeters;
use Monadial\Siphon\Unit\Space\Area\SquareMiles;
use Monadial\Siphon\Unit\Space\Area\SquareMillimeters;
use Monadial\Siphon\Unit\Space\Area\SquareYards;

/**
 * Area represents the extent of a two-dimensional surface.
 *
 * The SI derived unit is the square meter (m^2). Area is the product of two lengths
 * and is used to quantify surfaces, land parcels, cross-sections, and more.
 *
 * Available units: SquareMillimeters (mm^2), SquareCentimeters (cm^2), SquareMeters (m^2),
 * SquareKilometers (km^2), SquareInches (in^2), SquareFeet (ft^2), SquareYards (yd^2),
 * SquareMiles (mi^2), Acres (ac), Hectares (ha), Barns (b).
 *
 * Usage:
 *     $area = Area::squareMeters(100);
 *     $inAcres = $area->toAcres();
 *     $volume = $area->timesLength(Length::meters(3)); // 300 m^3
 *
 * @see AreaUnit for the abstract unit base class.
 * @template-extends Quantity<AreaUnit>
 */
final readonly class Area extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function acres(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Acres::make());
    }

    public static function acre(BigDecimal|int|float|string $value): self
    {
        return self::acres($value);
    }

    public static function barns(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Barns::make());
    }

    public static function barn(BigDecimal|int|float|string $value): self
    {
        return self::barns($value);
    }

    public static function hectares(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Hectares::make());
    }

    public static function hectare(BigDecimal|int|float|string $value): self
    {
        return self::hectares($value);
    }

    public static function squareCentimeters(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), SquareCentimeters::make());
    }

    public static function squareCentimeter(BigDecimal|int|float|string $value): self
    {
        return self::squareCentimeters($value);
    }

    public static function squareFeet(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), SquareFeet::make());
    }

    public static function squareInches(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), SquareInches::make());
    }

    public static function squareInch(BigDecimal|int|float|string $value): self
    {
        return self::squareInches($value);
    }

    public static function squareKilometers(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), SquareKilometers::make());
    }

    public static function squareKilometer(BigDecimal|int|float|string $value): self
    {
        return self::squareKilometers($value);
    }

    public static function squareMeters(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), SquareMeters::make());
    }

    public static function squareMeter(BigDecimal|int|float|string $value): self
    {
        return self::squareMeters($value);
    }

    public static function squareMiles(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), SquareMiles::make());
    }

    public static function squareMile(BigDecimal|int|float|string $value): self
    {
        return self::squareMiles($value);
    }

    public static function squareMillimeters(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), SquareMillimeters::make());
    }

    public static function squareMillimeter(BigDecimal|int|float|string $value): self
    {
        return self::squareMillimeters($value);
    }

    public static function squareYards(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), SquareYards::make());
    }

    public static function squareYard(BigDecimal|int|float|string $value): self
    {
        return self::squareYards($value);
    }

    // END_TYPED_FACTORIES
    public static function cubic(Length $length, Length $width, Length $height): Volume
    {
        return $length->timesLength($width)->timesLength($height);
    }

    public function toSquareMillimeters(): self
    {
        return $this->scaleTo(SquareMillimeters::make());
    }

    public function toSquareCentimeters(): self
    {
        return $this->scaleTo(SquareCentimeters::make());
    }

    public function toSquareMeters(): self
    {
        return $this->scaleTo(SquareMeters::make());
    }

    public function toHectares(): self
    {
        return $this->scaleTo(Hectares::make());
    }

    public function toSquareKilometers(): self
    {
        return $this->scaleTo(SquareKilometers::make());
    }

    public function toSquareInches(): self
    {
        return $this->scaleTo(SquareInches::make());
    }

    public function toSquareFeet(): self
    {
        return $this->scaleTo(SquareFeet::make());
    }

    public function toSquareYards(): self
    {
        return $this->scaleTo(SquareYards::make());
    }

    public function toSquareMiles(): self
    {
        return $this->scaleTo(SquareMiles::make());
    }

    public function toAcres(): self
    {
        return $this->scaleTo(Acres::make());
    }

    public function toBarns(): self
    {
        return $this->scaleTo(Barns::make());
    }

    // ---------------------------------------------------------------
    // Cross-dimensional operations
    // ---------------------------------------------------------------

    public function timesLength(Length $length): Volume
    {
        $base = $this->toBaseValue()->multipliedBy($length->toBaseValue());

        return Volume::cubicMeters($base);
    }
}
