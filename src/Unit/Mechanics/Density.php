<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Mass\Mass;
use Monadial\Siphon\Unit\Mechanics\Density\GramsPerCubicCentimeter;
use Monadial\Siphon\Unit\Mechanics\Density\GramsPerLitre;
use Monadial\Siphon\Unit\Mechanics\Density\KilogramsPerCubicMeter;
use Monadial\Siphon\Unit\Space\Volume;

/**
 * Density measures mass per unit volume of a substance.
 *
 * The SI unit of density is the kilogram per cubic meter (kg/m^3). Density is a derived
 * quantity with dimension M*L^-3. It characterizes how tightly matter is packed together
 * and is fundamental to fluid mechanics, material science, and buoyancy calculations.
 *
 * Available units: KilogramsPerCubicMeter (base, factor 1), GramsPerLitre (factor 1),
 * GramsPerCubicCentimeter (factor 1000).
 *
 * Cross-dimensional operations:
 * - Density * Volume = Mass (rho * V = m)
 *
 * Example usage:
 * ```
 * $water = Density::kilogramsPerCubicMeter(1000);
 * $steel = Density::gramsPerCubicCentimeter('7.85');
 * $mass = $water->timesVolume(Volume::litres(5));
 * ```
 *
 * @see DensityUnit for the abstract unit base class
 * @template-extends Quantity<DensityUnit>
 */
final readonly class Density extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function gramsPerCubicCentimeter(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), GramsPerCubicCentimeter::make());
    }

    public static function gramsPerLitre(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), GramsPerLitre::make());
    }

    public static function kilogramsPerCubicMeter(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), KilogramsPerCubicMeter::make());
    }

    // END_TYPED_FACTORIES
    public function toKilogramsPerCubicMeter(): self
    {
        return $this->scaleTo(KilogramsPerCubicMeter::make());
    }

    public function toGramsPerCubicCentimeter(): self
    {
        return $this->scaleTo(GramsPerCubicCentimeter::make());
    }

    public function toGramsPerLitre(): self
    {
        return $this->scaleTo(GramsPerLitre::make());
    }

    public function timesVolume(Volume $volume): Mass
    {
        $base = $this->toBaseValue()->multipliedBy($volume->toBaseValue());

        return Mass::kilograms($base);
    }
}
