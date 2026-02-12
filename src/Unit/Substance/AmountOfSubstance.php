<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Substance;

use Brick\Math\BigDecimal;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Substance\AmountOfSubstance\Kilomoles;
use Monadial\Siphon\Unit\Substance\AmountOfSubstance\Micromoles;
use Monadial\Siphon\Unit\Substance\AmountOfSubstance\Millimoles;
use Monadial\Siphon\Unit\Substance\AmountOfSubstance\Moles;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<AmountOfSubstanceUnit>
 */
final readonly class AmountOfSubstance extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function kilomoles(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kilomoles::make());
    }

    public static function kilomole(BigDecimal|int|float|string $value): self
    {
        return self::kilomoles($value);
    }

    public static function micromoles(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Micromoles::make());
    }

    public static function micromole(BigDecimal|int|float|string $value): self
    {
        return self::micromoles($value);
    }

    public static function millimoles(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Millimoles::make());
    }

    public static function millimole(BigDecimal|int|float|string $value): self
    {
        return self::millimoles($value);
    }

    public static function moles(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Moles::make());
    }

    public static function mole(BigDecimal|int|float|string $value): self
    {
        return self::moles($value);
    }

    // END_TYPED_FACTORIES
    public function toMicromoles(): self
    {
        return $this->scaleTo(Micromoles::make());
    }

    public function toMillimoles(): self
    {
        return $this->scaleTo(Millimoles::make());
    }

    public function toMoles(): self
    {
        return $this->scaleTo(Moles::make());
    }

    public function toKilomoles(): self
    {
        return $this->scaleTo(Kilomoles::make());
    }
}
