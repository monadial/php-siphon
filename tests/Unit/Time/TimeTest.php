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
use Monadial\Siphon\Unit\Time\TimeUnit;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Time::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(TimeUnit::class)]
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

    // ---------------------------------------------------------------
    // Factory method tests
    // ---------------------------------------------------------------

    public function testFactoryDays(): void
    {
        $q = Time::days(1);
        self::assertInstanceOf(Days::class, $q->uom());
    }

    public function testFactoryDay(): void
    {
        $q = Time::day(1);
        self::assertInstanceOf(Days::class, $q->uom());
    }

    public function testFactoryHours(): void
    {
        $q = Time::hours(1);
        self::assertInstanceOf(Hours::class, $q->uom());
    }

    public function testFactoryHour(): void
    {
        $q = Time::hour(1);
        self::assertInstanceOf(Hours::class, $q->uom());
    }

    public function testFactoryMicroseconds(): void
    {
        $q = Time::microseconds(1);
        self::assertInstanceOf(Microseconds::class, $q->uom());
    }

    public function testFactoryMicrosecond(): void
    {
        $q = Time::microsecond(1);
        self::assertInstanceOf(Microseconds::class, $q->uom());
    }

    public function testFactoryMilliseconds(): void
    {
        $q = Time::milliseconds(1);
        self::assertInstanceOf(Milliseconds::class, $q->uom());
    }

    public function testFactoryMillisecond(): void
    {
        $q = Time::millisecond(1);
        self::assertInstanceOf(Milliseconds::class, $q->uom());
    }

    public function testFactoryMinutes(): void
    {
        $q = Time::minutes(1);
        self::assertInstanceOf(Minutes::class, $q->uom());
    }

    public function testFactoryMinute(): void
    {
        $q = Time::minute(1);
        self::assertInstanceOf(Minutes::class, $q->uom());
    }

    public function testFactoryMonths(): void
    {
        $q = Time::months(1);
        self::assertInstanceOf(Months::class, $q->uom());
    }

    public function testFactoryMonth(): void
    {
        $q = Time::month(1);
        self::assertInstanceOf(Months::class, $q->uom());
    }

    public function testFactoryNanoseconds(): void
    {
        $q = Time::nanoseconds(1);
        self::assertInstanceOf(Nanoseconds::class, $q->uom());
    }

    public function testFactoryNanosecond(): void
    {
        $q = Time::nanosecond(1);
        self::assertInstanceOf(Nanoseconds::class, $q->uom());
    }

    public function testFactorySeconds(): void
    {
        $q = Time::seconds(1);
        self::assertInstanceOf(Seconds::class, $q->uom());
    }

    public function testFactorySecond(): void
    {
        $q = Time::second(1);
        self::assertInstanceOf(Seconds::class, $q->uom());
    }

    public function testFactoryWeeks(): void
    {
        $q = Time::weeks(1);
        self::assertInstanceOf(Weeks::class, $q->uom());
    }

    public function testFactoryWeek(): void
    {
        $q = Time::week(1);
        self::assertInstanceOf(Weeks::class, $q->uom());
    }

    public function testFactoryYears(): void
    {
        $q = Time::years(1);
        self::assertInstanceOf(Years::class, $q->uom());
    }

    public function testFactoryYear(): void
    {
        $q = Time::year(1);
        self::assertInstanceOf(Years::class, $q->uom());
    }

    // ---------------------------------------------------------------
    // Conversion method tests
    // ---------------------------------------------------------------

    public function testToNanoseconds(): void
    {
        $result = Time::seconds(1)->toNanoseconds();
        self::assertInstanceOf(Nanoseconds::class, $result->uom());
    }

    public function testToMicroseconds(): void
    {
        $result = Time::seconds(1)->toMicroseconds();
        self::assertInstanceOf(Microseconds::class, $result->uom());
    }

    public function testToMilliseconds(): void
    {
        $result = Time::seconds(1)->toMilliseconds();
        self::assertInstanceOf(Milliseconds::class, $result->uom());
    }

    public function testToSeconds(): void
    {
        $result = Time::minutes(1)->toSeconds();
        self::assertInstanceOf(Seconds::class, $result->uom());
    }

    public function testToMinutes(): void
    {
        $result = Time::hours(1)->toMinutes();
        self::assertInstanceOf(Minutes::class, $result->uom());
    }

    public function testToHours(): void
    {
        $result = Time::days(1)->toHours();
        self::assertInstanceOf(Hours::class, $result->uom());
    }

    public function testToDays(): void
    {
        $result = Time::weeks(1)->toDays();
        self::assertInstanceOf(Days::class, $result->uom());
    }

    public function testToWeeks(): void
    {
        $result = Time::days(7)->toWeeks();
        self::assertInstanceOf(Weeks::class, $result->uom());
    }

    public function testToMonths(): void
    {
        $result = Time::years(1)->toMonths();
        self::assertInstanceOf(Months::class, $result->uom());
    }

    public function testToYears(): void
    {
        $result = Time::months(12)->toYears();
        self::assertInstanceOf(Years::class, $result->uom());
    }
}
