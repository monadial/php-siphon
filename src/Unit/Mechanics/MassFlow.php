<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Brick\Math\BigDecimal;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Mechanics\MassFlow\KilogramsPerHour;
use Monadial\Siphon\Unit\Mechanics\MassFlow\KilogramsPerSecond;
use Monadial\Siphon\Unit\Mechanics\MassFlow\PoundsPerSecond;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<MassFlowUnit>
 */
final readonly class MassFlow extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function kilogramsPerHour(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), KilogramsPerHour::make());
    }

    public static function kilogramsPerSecond(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), KilogramsPerSecond::make());
    }

    public static function poundsPerSecond(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), PoundsPerSecond::make());
    }

    // END_TYPED_FACTORIES
    public function toKilogramsPerSecond(): self
    {
        return $this->scaleTo(KilogramsPerSecond::make());
    }

    public function toPoundsPerSecond(): self
    {
        return $this->scaleTo(PoundsPerSecond::make());
    }

    public function toKilogramsPerHour(): self
    {
        return $this->scaleTo(KilogramsPerHour::make());
    }
}
