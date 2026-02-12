<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Brick\Math\BigDecimal;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Mechanics\Density\GramsPerCubicCentimeter;
use Monadial\Siphon\Unit\Mechanics\Density\GramsPerLitre;
use Monadial\Siphon\Unit\Mechanics\Density\KilogramsPerCubicMeter;

/**
 * @psalm-api
 * @psalm-immutable
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
}
