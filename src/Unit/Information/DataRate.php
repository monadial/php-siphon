<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Information\DataRate\BitsPerSecond;
use Monadial\Siphon\Unit\Information\DataRate\BytesPerSecond;
use Monadial\Siphon\Unit\Information\DataRate\GigabitsPerSecond;
use Monadial\Siphon\Unit\Information\DataRate\GigabytesPerSecond;
use Monadial\Siphon\Unit\Information\DataRate\KilobitsPerSecond;
use Monadial\Siphon\Unit\Information\DataRate\KilobytesPerSecond;
use Monadial\Siphon\Unit\Information\DataRate\MegabitsPerSecond;
use Monadial\Siphon\Unit\Information\DataRate\MegabytesPerSecond;
use Monadial\Siphon\Unit\Information\DataRate\TerabytesPerSecond;
use Monadial\Siphon\Unit\Time\Time;

/**
 * Data transfer rate quantity measuring information throughput per unit time.
 *
 * Dimension formula: information / time (bit/s). The base unit is bytes per second (B/s).
 * Supports both bit-based rates (b/s, kb/s, Mb/s, Gb/s) and byte-based rates
 * (B/s, kB/s, MB/s, GB/s, TB/s).
 *
 * Cross-dimensional: DataRate * Time = Information.
 *
 * ```php
 * $rate = DataRate::megabitsPerSecond(100);
 * $bytesPerSec = $rate->toBytesPerSecond(); // 12,500,000 B/s
 * $downloaded = $rate->timesTime(Time::seconds(60)); // 750 MB
 * ```
 *
 * @template-extends Quantity<DataRateUnit>
 */
final readonly class DataRate extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function bitsPerSecond(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), BitsPerSecond::make());
    }

    public static function bytesPerSecond(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), BytesPerSecond::make());
    }

    public static function gigabitsPerSecond(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), GigabitsPerSecond::make());
    }

    public static function gigabytesPerSecond(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), GigabytesPerSecond::make());
    }

    public static function kilobitsPerSecond(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), KilobitsPerSecond::make());
    }

    public static function kilobytesPerSecond(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), KilobytesPerSecond::make());
    }

    public static function megabitsPerSecond(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), MegabitsPerSecond::make());
    }

    public static function megabytesPerSecond(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), MegabytesPerSecond::make());
    }

    public static function terabytesPerSecond(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), TerabytesPerSecond::make());
    }

    // END_TYPED_FACTORIES
    public function toBytesPerSecond(): self
    {
        return $this->scaleTo(BytesPerSecond::make());
    }

    public function toKilobytesPerSecond(): self
    {
        return $this->scaleTo(KilobytesPerSecond::make());
    }

    public function toMegabytesPerSecond(): self
    {
        return $this->scaleTo(MegabytesPerSecond::make());
    }

    public function toGigabytesPerSecond(): self
    {
        return $this->scaleTo(GigabytesPerSecond::make());
    }

    public function toTerabytesPerSecond(): self
    {
        return $this->scaleTo(TerabytesPerSecond::make());
    }

    public function toBitsPerSecond(): self
    {
        return $this->scaleTo(BitsPerSecond::make());
    }

    public function toKilobitsPerSecond(): self
    {
        return $this->scaleTo(KilobitsPerSecond::make());
    }

    public function toMegabitsPerSecond(): self
    {
        return $this->scaleTo(MegabitsPerSecond::make());
    }

    public function toGigabitsPerSecond(): self
    {
        return $this->scaleTo(GigabitsPerSecond::make());
    }

    public function timesTime(Time $time): Information
    {
        $base = $this->toBaseValue()->multipliedBy($time->toBaseValue());

        return Information::bytes($base);
    }
}
