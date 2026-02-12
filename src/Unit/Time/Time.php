<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Time;

use Brick\Math\BigDecimal;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Time\Time\Days;
use Monadial\Siphon\Unit\Time\Time\Hours;
use Monadial\Siphon\Unit\Time\Time\Microseconds;
use Monadial\Siphon\Unit\Time\Time\Milliseconds;
use Monadial\Siphon\Unit\Time\Time\Minutes;
use Monadial\Siphon\Unit\Time\Time\Months;
use Monadial\Siphon\Unit\Time\Time\Nanoseconds;
use Monadial\Siphon\Unit\Time\Time\Seconds;
use Monadial\Siphon\Unit\Time\Time\Weeks;
use Monadial\Siphon\Unit\Time\Time\Years;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<TimeUnit>
 */
final readonly class Time extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function days(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Days::make());
    }

    public static function day(BigDecimal|int|float|string $value): self
    {
        return self::days($value);
    }

    public static function hours(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Hours::make());
    }

    public static function hour(BigDecimal|int|float|string $value): self
    {
        return self::hours($value);
    }

    public static function microseconds(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Microseconds::make());
    }

    public static function microsecond(BigDecimal|int|float|string $value): self
    {
        return self::microseconds($value);
    }

    public static function milliseconds(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Milliseconds::make());
    }

    public static function millisecond(BigDecimal|int|float|string $value): self
    {
        return self::milliseconds($value);
    }

    public static function minutes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Minutes::make());
    }

    public static function minute(BigDecimal|int|float|string $value): self
    {
        return self::minutes($value);
    }

    public static function months(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Months::make());
    }

    public static function month(BigDecimal|int|float|string $value): self
    {
        return self::months($value);
    }

    public static function nanoseconds(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Nanoseconds::make());
    }

    public static function nanosecond(BigDecimal|int|float|string $value): self
    {
        return self::nanoseconds($value);
    }

    public static function seconds(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Seconds::make());
    }

    public static function second(BigDecimal|int|float|string $value): self
    {
        return self::seconds($value);
    }

    public static function weeks(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Weeks::make());
    }

    public static function week(BigDecimal|int|float|string $value): self
    {
        return self::weeks($value);
    }

    public static function years(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Years::make());
    }

    public static function year(BigDecimal|int|float|string $value): self
    {
        return self::years($value);
    }

    // END_TYPED_FACTORIES
    public function toNanoseconds(): self
    {
        return $this->scaleTo(Nanoseconds::make());
    }

    public function toMicroseconds(): self
    {
        return $this->scaleTo(Microseconds::make());
    }

    public function toMilliseconds(): self
    {
        return $this->scaleTo(Milliseconds::make());
    }

    public function toSeconds(): self
    {
        return $this->scaleTo(Seconds::make());
    }

    public function toMinutes(): self
    {
        return $this->scaleTo(Minutes::make());
    }

    public function toHours(): self
    {
        return $this->scaleTo(Hours::make());
    }

    public function toDays(): self
    {
        return $this->scaleTo(Days::make());
    }

    public function toWeeks(): self
    {
        return $this->scaleTo(Weeks::make());
    }

    public function toMonths(): self
    {
        return $this->scaleTo(Months::make());
    }

    public function toYears(): self
    {
        return $this->scaleTo(Years::make());
    }
}
