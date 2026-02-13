<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Electrical\ElectricalConductance\Microsiemens;
use Monadial\Siphon\Unit\Electrical\ElectricalConductance\Millisiemens;
use Monadial\Siphon\Unit\Electrical\ElectricalConductance\Siemens;

/**
 * Electrical conductance — the ease with which electric current flows through a conductor.
 *
 * SI base unit: siemens (S). Dimension: A^2 * s^3 * kg^-1 * m^-2.
 *
 * Conductance is the reciprocal of resistance: G = 1/R. One siemens is the
 * conductance of a conductor through which one ampere flows under one volt.
 *
 * Available units: {@see Microsiemens}, {@see Millisiemens}, {@see Siemens}.
 *
 * Usage:
 *
 *     $g = ElectricalConductance::siemens(2);
 *     $inMs = $g->toMillisiemens(); // 2000 mS
 *
 * @template-extends Quantity<ElectricalConductanceUnit>
 */
final readonly class ElectricalConductance extends Quantity
{
    /** Static factory methods for creating ElectricalConductance in any supported unit. */
    // BEGIN_TYPED_FACTORIES
    public static function microsiemens(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Microsiemens::make());
    }

    public static function millisiemens(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Millisiemens::make());
    }

    public static function siemens(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Siemens::make());
    }

    // END_TYPED_FACTORIES

    /** Convert this electrical conductance to the specified unit via {@see scaleTo()}. */
    public function toSiemens(): self
    {
        return $this->scaleTo(Siemens::make());
    }

    public function toMillisiemens(): self
    {
        return $this->scaleTo(Millisiemens::make());
    }

    public function toMicrosiemens(): self
    {
        return $this->scaleTo(Microsiemens::make());
    }
}
