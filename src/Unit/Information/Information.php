<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information;

use Brick\Math\BigDecimal;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Information\Information\Bits;
use Monadial\Siphon\Unit\Information\Information\Bytes;
use Monadial\Siphon\Unit\Information\Information\Exabytes;
use Monadial\Siphon\Unit\Information\Information\Exbibytes;
use Monadial\Siphon\Unit\Information\Information\Gibibytes;
use Monadial\Siphon\Unit\Information\Information\Gigabytes;
use Monadial\Siphon\Unit\Information\Information\Kibibytes;
use Monadial\Siphon\Unit\Information\Information\Kilobytes;
use Monadial\Siphon\Unit\Information\Information\Mebibytes;
use Monadial\Siphon\Unit\Information\Information\Megabytes;
use Monadial\Siphon\Unit\Information\Information\Pebibytes;
use Monadial\Siphon\Unit\Information\Information\Petabytes;
use Monadial\Siphon\Unit\Information\Information\Tebibytes;
use Monadial\Siphon\Unit\Information\Information\Terabytes;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<InformationUnit>
 */
final readonly class Information extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function bits(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Bits::make());
    }

    public static function bit(BigDecimal|int|float|string $value): self
    {
        return self::bits($value);
    }

    public static function bytes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Bytes::make());
    }

    public static function byte(BigDecimal|int|float|string $value): self
    {
        return self::bytes($value);
    }

    public static function exabytes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Exabytes::make());
    }

    public static function exabyte(BigDecimal|int|float|string $value): self
    {
        return self::exabytes($value);
    }

    public static function exbibytes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Exbibytes::make());
    }

    public static function exbibyte(BigDecimal|int|float|string $value): self
    {
        return self::exbibytes($value);
    }

    public static function gibibytes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Gibibytes::make());
    }

    public static function gibibyte(BigDecimal|int|float|string $value): self
    {
        return self::gibibytes($value);
    }

    public static function gigabytes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Gigabytes::make());
    }

    public static function gigabyte(BigDecimal|int|float|string $value): self
    {
        return self::gigabytes($value);
    }

    public static function kibibytes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kibibytes::make());
    }

    public static function kibibyte(BigDecimal|int|float|string $value): self
    {
        return self::kibibytes($value);
    }

    public static function kilobytes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kilobytes::make());
    }

    public static function kilobyte(BigDecimal|int|float|string $value): self
    {
        return self::kilobytes($value);
    }

    public static function mebibytes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Mebibytes::make());
    }

    public static function mebibyte(BigDecimal|int|float|string $value): self
    {
        return self::mebibytes($value);
    }

    public static function megabytes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Megabytes::make());
    }

    public static function megabyte(BigDecimal|int|float|string $value): self
    {
        return self::megabytes($value);
    }

    public static function pebibytes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Pebibytes::make());
    }

    public static function pebibyte(BigDecimal|int|float|string $value): self
    {
        return self::pebibytes($value);
    }

    public static function petabytes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Petabytes::make());
    }

    public static function petabyte(BigDecimal|int|float|string $value): self
    {
        return self::petabytes($value);
    }

    public static function tebibytes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Tebibytes::make());
    }

    public static function tebibyte(BigDecimal|int|float|string $value): self
    {
        return self::tebibytes($value);
    }

    public static function terabytes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Terabytes::make());
    }

    public static function terabyte(BigDecimal|int|float|string $value): self
    {
        return self::terabytes($value);
    }

    // END_TYPED_FACTORIES
    public function toBytes(): self
    {
        return $this->scaleTo(Bytes::make());
    }

    public function toBits(): self
    {
        return $this->scaleTo(Bits::make());
    }

    public function toKilobytes(): self
    {
        return $this->scaleTo(Kilobytes::make());
    }

    public function toMegabytes(): self
    {
        return $this->scaleTo(Megabytes::make());
    }

    public function toGigabytes(): self
    {
        return $this->scaleTo(Gigabytes::make());
    }

    public function toTerabytes(): self
    {
        return $this->scaleTo(Terabytes::make());
    }

    public function toPetabytes(): self
    {
        return $this->scaleTo(Petabytes::make());
    }

    public function toExabytes(): self
    {
        return $this->scaleTo(Exabytes::make());
    }

    public function toKibibytes(): self
    {
        return $this->scaleTo(Kibibytes::make());
    }

    public function toMebibytes(): self
    {
        return $this->scaleTo(Mebibytes::make());
    }

    public function toGibibytes(): self
    {
        return $this->scaleTo(Gibibytes::make());
    }

    public function toTebibytes(): self
    {
        return $this->scaleTo(Tebibytes::make());
    }

    public function toPebibytes(): self
    {
        return $this->scaleTo(Pebibytes::make());
    }

    public function toExbibytes(): self
    {
        return $this->scaleTo(Exbibytes::make());
    }
}
