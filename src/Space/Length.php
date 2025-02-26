<?php

declare(strict_types=1);

namespace Monadial\Siphon\Space;

use Fp\Functional\Option\Option;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Space\Length\Angstroms;
use Monadial\Siphon\Space\Length\Centimeters;
use Monadial\Siphon\Space\Length\Decameters;
use Monadial\Siphon\Space\Length\Decimeters;
use Monadial\Siphon\Space\Length\Hectometers;
use Monadial\Siphon\Space\Length\Kilometers;
use Monadial\Siphon\Space\Length\Meters;
use Monadial\Siphon\Space\Length\Microns;
use Monadial\Siphon\Space\Length\Millimeters;
use Monadial\Siphon\Space\Length\Nanometers;
use Stringable;

/**
 * @psalm-api
 * @template T of LengthUnit
 * @template-extends Quantity<T>
 */
final readonly class Length extends Quantity
{
    public static function fromString(Stringable|string $input): Option
    {
        return LengthDimension::fromString($input);
    }

    public function toArea(self $that): Area
    {
        return match (trye)


    }

    public function squared(): Area
    {
        return $this->toArea($this);
    }

    public function cubed(): Volume
    {
        return $this->toArea($this)->toVolume($this);
    }

    public function toAngstroms(): self
    {
        return $this->to(Angstroms::make());
    }

    /**
     * @return Length<Nanometers>
     */
    public function toNanometers(): self
    {
        return $this->to(Nanometers::make());
    }

    /**
     * @return Length<Microns>
     */
    public function toMicrons(): self
    {
        return $this->to(Microns::make());
    }

    /**
     * @return Length<Millimeters>
     */
    public function toMillimeters(): self
    {
        return $this->to(Millimeters::make());
    }

    /**
     * @return Length<Centimeters>
     */
    public function toCentimeters(): self
    {
        return $this->to(Centimeters::make());
    }

    /**
     * @return Length<Decimeters>
     */
    public function toDecimeters(): self
    {
        return $this->to(Decimeters::make());
    }

    /**
     * @return Length<Meters>
     */
    public function toMeters(): self
    {
        return $this->to(Meters::make());
    }

    /**
     * @return Length<Decameters>
     */
    public function toDecameters(): self
    {
        return $this->to(Decameters::make());
    }

    /**
     * @return Length<Hectometers>
     */
    public function toHectometers(): self
    {
        return $this->to(Hectometers::make());
    }

    /**
     * @return Length<Kilometers>
     */
    public function toKilometers(): self
    {
        return $this->to(Kilometers::make());
    }
}
