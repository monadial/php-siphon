<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Time;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Time\Time;
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
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Time::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(Nanoseconds::class)]
#[UsesClass(Microseconds::class)]
#[UsesClass(Milliseconds::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Hours::class)]
#[UsesClass(Days::class)]
#[UsesClass(Weeks::class)]
#[UsesClass(Months::class)]
#[UsesClass(Years::class)]
final class TimeTest extends TestCase
{
    public function testIdentityConversion(): void
    {
        $time = new Time(BigDecimal::of('5.5'), Seconds::make());
        $result = $time->toSeconds();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5.5')));
    }

    public function testSecondsToMilliseconds(): void
    {
        $time = new Time(BigDecimal::of('1'), Seconds::make());
        $result = $time->toMilliseconds();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testSecondsToMicroseconds(): void
    {
        $time = new Time(BigDecimal::of('1'), Seconds::make());
        $result = $time->toMicroseconds();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    public function testSecondsToNanoseconds(): void
    {
        $time = new Time(BigDecimal::of('1'), Seconds::make());
        $result = $time->toNanoseconds();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000000')));
    }

    public function testMinutesToSeconds(): void
    {
        $time = new Time(BigDecimal::of('1'), Minutes::make());
        $result = $time->toSeconds();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('60')));
    }

    public function testHoursToSeconds(): void
    {
        $time = new Time(BigDecimal::of('1'), Hours::make());
        $result = $time->toSeconds();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('3600')));
    }

    public function testHoursToMinutes(): void
    {
        $time = new Time(BigDecimal::of('1'), Hours::make());
        $result = $time->toMinutes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('60')));
    }

    public function testDaysToHours(): void
    {
        $time = new Time(BigDecimal::of('1'), Days::make());
        $result = $time->toHours();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('24')));
    }

    public function testDaysToSeconds(): void
    {
        $time = new Time(BigDecimal::of('1'), Days::make());
        $result = $time->toSeconds();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('86400')));
    }

    public function testMinutesToHours(): void
    {
        $time = new Time(BigDecimal::of('90'), Minutes::make());
        $result = $time->toHours();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1.5')));
    }

    public function testSecondsToHours(): void
    {
        $time = new Time(BigDecimal::of('7200'), Seconds::make());
        $result = $time->toHours();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('2')));
    }

    // ---------------------------------------------------------------
    // Weeks, Months, Years conversions
    // ---------------------------------------------------------------

    public function testWeeksToSeconds(): void
    {
        $time = new Time(BigDecimal::of('1'), Weeks::make());
        $result = $time->toSeconds();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('604800')));
        self::assertInstanceOf(Seconds::class, $result->uom());
    }

    public function testWeeksToDays(): void
    {
        $time = new Time(BigDecimal::of('1'), Weeks::make());
        $result = $time->toDays();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('7')));
    }

    public function testDaysToWeeks(): void
    {
        $time = new Time(BigDecimal::of('14'), Days::make());
        $result = $time->toWeeks();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('2')));
    }

    public function testWeeksToHours(): void
    {
        $time = new Time(BigDecimal::of('1'), Weeks::make());
        $result = $time->toHours();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('168')));
    }

    public function testMonthsToSeconds(): void
    {
        $time = new Time(BigDecimal::of('1'), Months::make());
        $result = $time->toSeconds();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('2629746')));
        self::assertInstanceOf(Seconds::class, $result->uom());
    }

    public function testMonthsToDays(): void
    {
        $time = new Time(BigDecimal::of('1'), Months::make());
        $result = $time->toDays();

        self::assertEqualsWithDelta(30.4369, (float) (string) $result->value(), 0.001);
    }

    public function testYearsToSeconds(): void
    {
        $time = new Time(BigDecimal::of('1'), Years::make());
        $result = $time->toSeconds();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('31556952')));
        self::assertInstanceOf(Seconds::class, $result->uom());
    }

    public function testYearsToDays(): void
    {
        $time = new Time(BigDecimal::of('1'), Years::make());
        $result = $time->toDays();

        self::assertEqualsWithDelta(365.2425, (float) (string) $result->value(), 0.001);
    }

    public function testYearsToMonths(): void
    {
        $time = new Time(BigDecimal::of('1'), Years::make());
        $result = $time->toMonths();

        self::assertEqualsWithDelta(12.0, (float) (string) $result->value(), 0.001);
    }

    public function testYearsToWeeks(): void
    {
        $time = new Time(BigDecimal::of('1'), Years::make());
        $result = $time->toWeeks();

        self::assertEqualsWithDelta(52.1775, (float) (string) $result->value(), 0.001);
    }

    // ---------------------------------------------------------------
    // Identity conversions for new units
    // ---------------------------------------------------------------

    public function testIdentityConversionWeeks(): void
    {
        $time = new Time(BigDecimal::of('4'), Weeks::make());
        $result = $time->toWeeks();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('4')));
        self::assertInstanceOf(Weeks::class, $result->uom());
    }

    public function testIdentityConversionYears(): void
    {
        $time = new Time(BigDecimal::of('10'), Years::make());
        $result = $time->toYears();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('10')));
        self::assertInstanceOf(Years::class, $result->uom());
    }

    // ---------------------------------------------------------------
    // Round-trip conversions for new units
    // ---------------------------------------------------------------

    public function testRoundTripDaysToWeeksAndBack(): void
    {
        $original = new Time(BigDecimal::of('21'), Days::make());
        $converted = $original->toWeeks();
        $roundTrip = $converted->toDays();

        self::assertEqualsWithDelta(21.0, (float) (string) $roundTrip->value(), 0.0001);
    }

    public function testRoundTripSecondsToYearsAndBack(): void
    {
        $original = new Time(BigDecimal::of('31556952'), Seconds::make());
        $converted = $original->toYears();
        $roundTrip = $converted->toSeconds();

        self::assertEqualsWithDelta(31556952.0, (float) (string) $roundTrip->value(), 0.01);
    }

    // ---------------------------------------------------------------
    // Unit of measure preservation for new units
    // ---------------------------------------------------------------

    public function testNewUnitsPreserveUnitOfMeasure(): void
    {
        $time = new Time(BigDecimal::of('1'), Seconds::make());

        self::assertInstanceOf(Weeks::class, $time->toWeeks()->uom());
        self::assertInstanceOf(Months::class, $time->toMonths()->uom());
        self::assertInstanceOf(Years::class, $time->toYears()->uom());
    }
}
