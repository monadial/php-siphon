<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Brick\Math\BigDecimal;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Electrical\ElectricCharge\AmpereHours;
use Monadial\Siphon\Unit\Electrical\ElectricCharge\Coulombs;
use Monadial\Siphon\Unit\Electrical\ElectricCharge\Microcoulombs;
use Monadial\Siphon\Unit\Electrical\ElectricCharge\MilliampereHours;
use Monadial\Siphon\Unit\Electrical\ElectricCharge\Millicoulombs;
use Monadial\Siphon\Unit\Electrical\ElectricCharge\Nanocoulombs;
use Monadial\Siphon\Unit\Electrical\ElectricCharge\Picocoulombs;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<ElectricChargeUnit>
 */
final readonly class ElectricCharge extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function ampereHours(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), AmpereHours::make());
    }

    public static function ampereHour(BigDecimal|int|float|string $value): self
    {
        return self::ampereHours($value);
    }

    public static function coulombs(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Coulombs::make());
    }

    public static function coulomb(BigDecimal|int|float|string $value): self
    {
        return self::coulombs($value);
    }

    public static function microcoulombs(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Microcoulombs::make());
    }

    public static function microcoulomb(BigDecimal|int|float|string $value): self
    {
        return self::microcoulombs($value);
    }

    public static function milliampereHours(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), MilliampereHours::make());
    }

    public static function milliampereHour(BigDecimal|int|float|string $value): self
    {
        return self::milliampereHours($value);
    }

    public static function millicoulombs(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Millicoulombs::make());
    }

    public static function millicoulomb(BigDecimal|int|float|string $value): self
    {
        return self::millicoulombs($value);
    }

    public static function nanocoulombs(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Nanocoulombs::make());
    }

    public static function nanocoulomb(BigDecimal|int|float|string $value): self
    {
        return self::nanocoulombs($value);
    }

    public static function picocoulombs(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Picocoulombs::make());
    }

    public static function picocoulomb(BigDecimal|int|float|string $value): self
    {
        return self::picocoulombs($value);
    }

    // END_TYPED_FACTORIES
    public function toCoulombs(): self
    {
        return $this->scaleTo(Coulombs::make());
    }

    public function toMillicoulombs(): self
    {
        return $this->scaleTo(Millicoulombs::make());
    }

    public function toMicrocoulombs(): self
    {
        return $this->scaleTo(Microcoulombs::make());
    }

    public function toNanocoulombs(): self
    {
        return $this->scaleTo(Nanocoulombs::make());
    }

    public function toPicocoulombs(): self
    {
        return $this->scaleTo(Picocoulombs::make());
    }

    public function toAmpereHours(): self
    {
        return $this->scaleTo(AmpereHours::make());
    }

    public function toMilliampereHours(): self
    {
        return $this->scaleTo(MilliampereHours::make());
    }
}
