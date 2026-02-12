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
use Monadial\Siphon\Unit\Space\Volume\CubicMeters;

/**
 * @psalm-api
 * @psalm-immutable
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
    public static function cubic(
        BigDecimal|int|float|string $length,
        BigDecimal|int|float|string $width,
        BigDecimal|int|float|string $height,
    ): Volume {
        return new Volume(
            BigDecimal::of($length)->multipliedBy(BigDecimal::of($width))->multipliedBy(BigDecimal::of($height)),
            CubicMeters::make(),
        );
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
