<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Brick\Math\BigDecimal;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Electrical\ElectricalConductance\Microsiemens;
use Monadial\Siphon\Unit\Electrical\ElectricalConductance\Millisiemens;
use Monadial\Siphon\Unit\Electrical\ElectricalConductance\Siemens;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<ElectricalConductanceUnit>
 */
final readonly class ElectricalConductance extends Quantity
{
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
