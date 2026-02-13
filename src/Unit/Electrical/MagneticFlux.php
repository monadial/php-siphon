<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Electrical\MagneticFlux\Microwebers;
use Monadial\Siphon\Unit\Electrical\MagneticFlux\Milliwebers;
use Monadial\Siphon\Unit\Electrical\MagneticFlux\Webers;

/**
 * Magnetic flux — the total magnetic field passing through a surface.
 *
 * SI base unit: weber (Wb). Dimension: kg * m^2 * s^-2 * A^-1.
 *
 * One weber is the magnetic flux that, linking a circuit of one turn, would
 * produce an EMF of one volt if reduced to zero at a uniform rate in one second.
 * Relationship: Phi = V * s.
 *
 * Available units: {@see Microwebers}, {@see Milliwebers}, {@see Webers}.
 *
 * Usage:
 *
 *     $phi = MagneticFlux::webers('0.005');
 *     $inMilli = $phi->toMilliwebers(); // 5 mWb
 *
 * @template-extends Quantity<MagneticFluxUnit>
 */
final readonly class MagneticFlux extends Quantity
{
    /** Static factory methods for creating MagneticFlux in any supported unit. */
    // BEGIN_TYPED_FACTORIES
    public static function microwebers(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Microwebers::make());
    }

    public static function microweber(BigDecimal|int|float|string $value): self
    {
        return self::microwebers($value);
    }

    public static function milliwebers(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Milliwebers::make());
    }

    public static function milliweber(BigDecimal|int|float|string $value): self
    {
        return self::milliwebers($value);
    }

    public static function webers(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Webers::make());
    }

    public static function weber(BigDecimal|int|float|string $value): self
    {
        return self::webers($value);
    }

    // END_TYPED_FACTORIES

    /** Convert this magnetic flux to the specified unit via {@see scaleTo()}. */
    public function toMicrowebers(): self
    {
        return $this->scaleTo(Microwebers::make());
    }

    public function toMilliwebers(): self
    {
        return $this->scaleTo(Milliwebers::make());
    }

    public function toWebers(): self
    {
        return $this->scaleTo(Webers::make());
    }
}
