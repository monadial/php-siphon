<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Brick\Math\BigDecimal;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Electrical\Capacitance\Farads;
use Monadial\Siphon\Unit\Electrical\Capacitance\Kilofarads;
use Monadial\Siphon\Unit\Electrical\Capacitance\Microfarads;
use Monadial\Siphon\Unit\Electrical\Capacitance\Millifarads;
use Monadial\Siphon\Unit\Electrical\Capacitance\Nanofarads;
use Monadial\Siphon\Unit\Electrical\Capacitance\Picofarads;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<CapacitanceUnit>
 */
final readonly class Capacitance extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function farads(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Farads::make());
    }

    public static function farad(BigDecimal|int|float|string $value): self
    {
        return self::farads($value);
    }

    public static function kilofarads(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kilofarads::make());
    }

    public static function kilofarad(BigDecimal|int|float|string $value): self
    {
        return self::kilofarads($value);
    }

    public static function microfarads(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Microfarads::make());
    }

    public static function microfarad(BigDecimal|int|float|string $value): self
    {
        return self::microfarads($value);
    }

    public static function millifarads(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Millifarads::make());
    }

    public static function millifarad(BigDecimal|int|float|string $value): self
    {
        return self::millifarads($value);
    }

    public static function nanofarads(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Nanofarads::make());
    }

    public static function nanofarad(BigDecimal|int|float|string $value): self
    {
        return self::nanofarads($value);
    }

    public static function picofarads(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Picofarads::make());
    }

    public static function picofarad(BigDecimal|int|float|string $value): self
    {
        return self::picofarads($value);
    }

    // END_TYPED_FACTORIES
    public function toPicofarads(): self
    {
        return $this->scaleTo(Picofarads::make());
    }

    public function toNanofarads(): self
    {
        return $this->scaleTo(Nanofarads::make());
    }

    public function toMicrofarads(): self
    {
        return $this->scaleTo(Microfarads::make());
    }

    public function toMillifarads(): self
    {
        return $this->scaleTo(Millifarads::make());
    }

    public function toFarads(): self
    {
        return $this->scaleTo(Farads::make());
    }

    public function toKilofarads(): self
    {
        return $this->scaleTo(Kilofarads::make());
    }
}
