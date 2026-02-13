<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Electrical\MagneticFluxDensity\Gauss;
use Monadial\Siphon\Unit\Electrical\MagneticFluxDensity\Microteslas;
use Monadial\Siphon\Unit\Electrical\MagneticFluxDensity\Milliteslas;
use Monadial\Siphon\Unit\Electrical\MagneticFluxDensity\Teslas;

/**
 * Magnetic flux density — the strength of a magnetic field per unit area.
 *
 * SI base unit: tesla (T). Dimension: kg * s^-2 * A^-1.
 *
 * One tesla equals one weber per square meter. The relationship B = Phi / A
 * connects flux density, total flux, and area. Earth's magnetic field is
 * approximately 25-65 uT; an MRI machine typically operates at 1.5-3 T.
 *
 * Available units: {@see Microteslas}, {@see Milliteslas}, {@see Teslas},
 * {@see Gauss}.
 *
 * Usage:
 *
 *     $b = MagneticFluxDensity::teslas('1.5');
 *     $inGauss = $b->toGauss(); // 15000 Gs
 *
 * @template-extends Quantity<MagneticFluxDensityUnit>
 */
final readonly class MagneticFluxDensity extends Quantity
{
    /** Static factory methods for creating MagneticFluxDensity in any supported unit. */
    // BEGIN_TYPED_FACTORIES
    public static function gauss(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Gauss::make());
    }

    public static function gaus(BigDecimal|int|float|string $value): self
    {
        return self::gauss($value);
    }

    public static function microteslas(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Microteslas::make());
    }

    public static function microtesla(BigDecimal|int|float|string $value): self
    {
        return self::microteslas($value);
    }

    public static function milliteslas(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Milliteslas::make());
    }

    public static function millitesla(BigDecimal|int|float|string $value): self
    {
        return self::milliteslas($value);
    }

    public static function teslas(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Teslas::make());
    }

    public static function tesla(BigDecimal|int|float|string $value): self
    {
        return self::teslas($value);
    }

    // END_TYPED_FACTORIES

    /** Convert this magnetic flux density to the specified unit via {@see scaleTo()}. */
    public function toMicroteslas(): self
    {
        return $this->scaleTo(Microteslas::make());
    }

    public function toMilliteslas(): self
    {
        return $this->scaleTo(Milliteslas::make());
    }

    public function toTeslas(): self
    {
        return $this->scaleTo(Teslas::make());
    }

    public function toGauss(): self
    {
        return $this->scaleTo(Gauss::make());
    }
}
