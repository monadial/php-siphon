<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Brick\Math\BigDecimal;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance\Gigohms;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance\Kilohms;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance\Megohms;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance\Microhms;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance\Milliohms;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance\Nanohms;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance\Ohms;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<ElectricalResistanceUnit>
 */
final readonly class ElectricalResistance extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function gigohms(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Gigohms::make());
    }

    public static function gigohm(BigDecimal|int|float|string $value): self
    {
        return self::gigohms($value);
    }

    public static function kilohms(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kilohms::make());
    }

    public static function kilohm(BigDecimal|int|float|string $value): self
    {
        return self::kilohms($value);
    }

    public static function megohms(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Megohms::make());
    }

    public static function megohm(BigDecimal|int|float|string $value): self
    {
        return self::megohms($value);
    }

    public static function microhms(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Microhms::make());
    }

    public static function microhm(BigDecimal|int|float|string $value): self
    {
        return self::microhms($value);
    }

    public static function milliohms(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Milliohms::make());
    }

    public static function milliohm(BigDecimal|int|float|string $value): self
    {
        return self::milliohms($value);
    }

    public static function nanohms(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Nanohms::make());
    }

    public static function nanohm(BigDecimal|int|float|string $value): self
    {
        return self::nanohms($value);
    }

    public static function ohms(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Ohms::make());
    }

    public static function ohm(BigDecimal|int|float|string $value): self
    {
        return self::ohms($value);
    }

    // END_TYPED_FACTORIES
    public function toOhms(): self
    {
        return $this->scaleTo(Ohms::make());
    }

    public function toNanohms(): self
    {
        return $this->scaleTo(Nanohms::make());
    }

    public function toMicrohms(): self
    {
        return $this->scaleTo(Microhms::make());
    }

    public function toMilliohms(): self
    {
        return $this->scaleTo(Milliohms::make());
    }

    public function toKilohms(): self
    {
        return $this->scaleTo(Kilohms::make());
    }

    public function toMegohms(): self
    {
        return $this->scaleTo(Megohms::make());
    }

    public function toGigohms(): self
    {
        return $this->scaleTo(Gigohms::make());
    }
}
