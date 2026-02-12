<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Brick\Math\BigDecimal;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Mechanics\Power;
use Monadial\Siphon\Unit\Electrical\ElectricPotential\Kilovolts;
use Monadial\Siphon\Unit\Electrical\ElectricPotential\Megavolts;
use Monadial\Siphon\Unit\Electrical\ElectricPotential\Microvolts;
use Monadial\Siphon\Unit\Electrical\ElectricPotential\Millivolts;
use Monadial\Siphon\Unit\Electrical\ElectricPotential\Volts;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<ElectricPotentialUnit>
 */
final readonly class ElectricPotential extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function kilovolts(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kilovolts::make());
    }

    public static function kilovolt(BigDecimal|int|float|string $value): self
    {
        return self::kilovolts($value);
    }

    public static function megavolts(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Megavolts::make());
    }

    public static function megavolt(BigDecimal|int|float|string $value): self
    {
        return self::megavolts($value);
    }

    public static function microvolts(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Microvolts::make());
    }

    public static function microvolt(BigDecimal|int|float|string $value): self
    {
        return self::microvolts($value);
    }

    public static function millivolts(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Millivolts::make());
    }

    public static function millivolt(BigDecimal|int|float|string $value): self
    {
        return self::millivolts($value);
    }

    public static function volts(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Volts::make());
    }

    public static function volt(BigDecimal|int|float|string $value): self
    {
        return self::volts($value);
    }

    // END_TYPED_FACTORIES
    public function toVolts(): self
    {
        return $this->scaleTo(Volts::make());
    }

    public function toMicrovolts(): self
    {
        return $this->scaleTo(Microvolts::make());
    }

    public function toMillivolts(): self
    {
        return $this->scaleTo(Millivolts::make());
    }

    public function toKilovolts(): self
    {
        return $this->scaleTo(Kilovolts::make());
    }

    public function toMegavolts(): self
    {
        return $this->scaleTo(Megavolts::make());
    }

    // ---------------------------------------------------------------
    // Cross-dimensional operations
    // ---------------------------------------------------------------

    /**
     * @psalm-suppress ImpureMethodCall
     */
    public function timesCurrent(ElectricCurrent $current): Power
    {
        $base = $this->toBaseValue()->multipliedBy($current->toBaseValue());
        return Power::watts($base);
    }
}
