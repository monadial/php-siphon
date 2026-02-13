<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Electrical\Capacitance\Farads;
use Monadial\Siphon\Unit\Electrical\Capacitance\Kilofarads;
use Monadial\Siphon\Unit\Electrical\Capacitance\Microfarads;
use Monadial\Siphon\Unit\Electrical\Capacitance\Millifarads;
use Monadial\Siphon\Unit\Electrical\Capacitance\Nanofarads;
use Monadial\Siphon\Unit\Electrical\Capacitance\Picofarads;

/**
 * Electrical capacitance — the ability of a system to store electric charge per unit voltage.
 *
 * SI base unit: farad (F). Dimension: A^2 * s^4 * kg^-1 * m^-2.
 *
 * One farad is the capacitance of a capacitor that stores one coulomb of charge
 * at one volt. Typical values: ceramic capacitors 1 pF-100 nF, electrolytic
 * capacitors 1 uF-10000 uF, supercapacitors up to thousands of farads.
 *
 * Available units: {@see Picofarads}, {@see Nanofarads}, {@see Microfarads},
 * {@see Millifarads}, {@see Farads}, {@see Kilofarads}.
 *
 * Usage:
 *
 *     $c = Capacitance::microfarads(100);
 *     $inNano = $c->toNanofarads(); // 100000 nF
 *
 * @template-extends Quantity<CapacitanceUnit>
 */
final readonly class Capacitance extends Quantity
{
    /** Static factory methods for creating Capacitance in any supported unit. */
    // BEGIN_TYPED_FACTORIES
    public static function farads(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Farads::make());
    }

    public static function farad(BigDecimal|int|float|string $value): self
    {
        return self::farads($value);
    }

    public static function kilofarads(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kilofarads::make());
    }

    public static function kilofarad(BigDecimal|int|float|string $value): self
    {
        return self::kilofarads($value);
    }

    public static function microfarads(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Microfarads::make());
    }

    public static function microfarad(BigDecimal|int|float|string $value): self
    {
        return self::microfarads($value);
    }

    public static function millifarads(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Millifarads::make());
    }

    public static function millifarad(BigDecimal|int|float|string $value): self
    {
        return self::millifarads($value);
    }

    public static function nanofarads(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Nanofarads::make());
    }

    public static function nanofarad(BigDecimal|int|float|string $value): self
    {
        return self::nanofarads($value);
    }

    public static function picofarads(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Picofarads::make());
    }

    public static function picofarad(BigDecimal|int|float|string $value): self
    {
        return self::picofarads($value);
    }

    // END_TYPED_FACTORIES

    /** Convert this capacitance to the specified unit via {@see scaleTo()}. */
    public function toPicofarads(): self
    {
        return $this->scaleTo(Picofarads::make());
    }

    public function toNanofarads(): self
    {
        return $this->scaleTo(Nanofarads::make());
    }

    public function toMicrofarads(): self
    {
        return $this->scaleTo(Microfarads::make());
    }

    public function toMillifarads(): self
    {
        return $this->scaleTo(Millifarads::make());
    }

    public function toFarads(): self
    {
        return $this->scaleTo(Farads::make());
    }

    public function toKilofarads(): self
    {
        return $this->scaleTo(Kilofarads::make());
    }

    /**
     * Compute electric charge: Q = C * V (capacitance times voltage).
     *
     * @param ElectricPotential $potential the voltage across the capacitor
     * @return ElectricCharge the stored charge in coulombs
     */
    public function timesPotential(ElectricPotential $potential): ElectricCharge
    {
        $base = $this->toBaseValue()->multipliedBy($potential->toBaseValue());

        return ElectricCharge::coulombs($base);
    }
}
