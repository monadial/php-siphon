<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Mechanics;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Exception\UnitNotFound;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\Energy;
use Monadial\Siphon\Unit\Mechanics\Energy\WattHours;
use Monadial\Siphon\Unit\Mechanics\Power;
use Monadial\Siphon\Unit\Mechanics\Power\BtusPerHour;
use Monadial\Siphon\Unit\Mechanics\Power\Gigawatts;
use Monadial\Siphon\Unit\Mechanics\Power\Horsepower;
use Monadial\Siphon\Unit\Mechanics\Power\Kilowatts;
use Monadial\Siphon\Unit\Mechanics\Power\Megawatts;
use Monadial\Siphon\Unit\Mechanics\Power\Milliwatts;
use Monadial\Siphon\Unit\Mechanics\Power\Watts;
use Monadial\Siphon\Unit\Mechanics\PowerUnit;
use Monadial\Siphon\Unit\Time\Time;
use Monadial\Siphon\Unit\Time\Time\Hours;
use Monadial\Siphon\Unit\Time\Time\Seconds;
use Monadial\Siphon\Unit\Time\TimeUnit;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Power::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(PowerUnit::class)]
#[UsesClass(Watts::class)]
#[UsesClass(Milliwatts::class)]
#[UsesClass(Kilowatts::class)]
#[UsesClass(Megawatts::class)]
#[UsesClass(Gigawatts::class)]
#[UsesClass(Horsepower::class)]
#[UsesClass(BtusPerHour::class)]
#[UsesClass(Energy::class)]
#[UsesClass(WattHours::class)]
#[UsesClass(Time::class)]
#[UsesClass(TimeUnit::class)]
#[UsesClass(Hours::class)]
#[UsesClass(Seconds::class)]
final class PowerTest extends TestCase
{
    // ---------------------------------------------------------------
    // Identity conversions
    // ---------------------------------------------------------------

    public function testIdentityWatts(): void
    {
        $p = new Power(BigDecimal::of('500'), Watts::make());
        $result = $p->toWatts();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('500')));
        self::assertInstanceOf(Watts::class, $result->uom());
    }

    // ---------------------------------------------------------------
    // Metric conversions (exact)
    // ---------------------------------------------------------------

    public function testWattsToMilliwatts(): void
    {
        $p = new Power(BigDecimal::of('1'), Watts::make());
        $result = $p->toMilliwatts();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
        self::assertInstanceOf(Milliwatts::class, $result->uom());
    }

    public function testMilliwattsToWatts(): void
    {
        $p = new Power(BigDecimal::of('1000'), Milliwatts::make());
        $result = $p->toWatts();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testWattsToKilowatts(): void
    {
        $p = new Power(BigDecimal::of('1000'), Watts::make());
        $result = $p->toKilowatts();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(Kilowatts::class, $result->uom());
    }

    public function testKilowattsToWatts(): void
    {
        $p = new Power(BigDecimal::of('1'), Kilowatts::make());
        $result = $p->toWatts();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testWattsToMegawatts(): void
    {
        $p = new Power(BigDecimal::of('1000000'), Watts::make());
        $result = $p->toMegawatts();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(Megawatts::class, $result->uom());
    }

    public function testMegawattsToWatts(): void
    {
        $p = new Power(BigDecimal::of('1'), Megawatts::make());
        $result = $p->toWatts();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    public function testWattsToGigawatts(): void
    {
        $p = new Power(BigDecimal::of('1000000000'), Watts::make());
        $result = $p->toGigawatts();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(Gigawatts::class, $result->uom());
    }

    public function testGigawattsToWatts(): void
    {
        $p = new Power(BigDecimal::of('1'), Gigawatts::make());
        $result = $p->toWatts();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000000')));
    }

    // ---------------------------------------------------------------
    // Non-metric conversions (approximate)
    // ---------------------------------------------------------------

    public function testWattsToHorsepower(): void
    {
        $p = new Power(BigDecimal::of('745.69987158227022'), Watts::make());
        $result = $p->toHorsepower();

        self::assertEqualsWithDelta(1.0, (float) (string) $result->value(), 0.0001);
        self::assertInstanceOf(Horsepower::class, $result->uom());
    }

    public function testHorsepowerToWatts(): void
    {
        $p = new Power(BigDecimal::of('1'), Horsepower::make());
        $result = $p->toWatts();

        self::assertEqualsWithDelta(745.7, (float) (string) $result->value(), 0.1);
    }

    public function testWattsToBtusPerHour(): void
    {
        $p = new Power(BigDecimal::of('1'), Watts::make());
        $result = $p->toBtusPerHour();

        self::assertEqualsWithDelta(3.41214, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(BtusPerHour::class, $result->uom());
    }

    public function testBtusPerHourToWatts(): void
    {
        $p = new Power(BigDecimal::of('1'), BtusPerHour::make());
        $result = $p->toWatts();

        self::assertEqualsWithDelta(0.29307, (float) (string) $result->value(), 0.001);
    }

    // ---------------------------------------------------------------
    // Cross-conversions
    // ---------------------------------------------------------------

    public function testHorsepowerToKilowatts(): void
    {
        $p = new Power(BigDecimal::of('1'), Horsepower::make());
        $result = $p->toKilowatts();

        self::assertEqualsWithDelta(0.7457, (float) (string) $result->value(), 0.001);
    }

    // ---------------------------------------------------------------
    // Zero value
    // ---------------------------------------------------------------

    public function testZeroValueConversion(): void
    {
        $p = new Power(BigDecimal::of('0'), Watts::make());
        $result = $p->toHorsepower();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0')));
    }

    // ---------------------------------------------------------------
    // Round-trip
    // ---------------------------------------------------------------

    public function testRoundTripWattsToHorsepower(): void
    {
        $original = new Power(BigDecimal::of('1000'), Watts::make());
        $converted = $original->toHorsepower();
        $roundTrip = $converted->toWatts();

        self::assertEqualsWithDelta(1000.0, (float) (string) $roundTrip->value(), 0.001);
    }

    // ---------------------------------------------------------------
    // Return type checks
    // ---------------------------------------------------------------

    public function testScaleToReturnsPowerInstance(): void
    {
        $p = new Power(BigDecimal::of('1'), Watts::make());
        $result = $p->toKilowatts();

        self::assertInstanceOf(Power::class, $result);
    }

    /** @throws UnitNotFound */
    public function testConstructionWithFromDsl(): void
    {
        $power = Watts::from(100);

        self::assertTrue($power->value()->isEqualTo(BigDecimal::of('100')));
        self::assertInstanceOf(Watts::class, $power->uom());
    }

    public function testStaticDslConstructionWithPluralUnitName(): void
    {
        $power = Power::watts(100);

        self::assertTrue($power->value()->isEqualTo(BigDecimal::of('100')));
        self::assertInstanceOf(Watts::class, $power->uom());
    }

    public function testStaticDslConstructionWithSingularUnitName(): void
    {
        $power = Power::watt(100);

        self::assertTrue($power->value()->isEqualTo(BigDecimal::of('100')));
        self::assertInstanceOf(Watts::class, $power->uom());
    }

    public function testTypedConversionToKilowatts(): void
    {
        $power = Power::watts(1500)->toKilowatts();

        self::assertTrue($power->value()->isEqualTo(BigDecimal::of('1.5')));
        self::assertInstanceOf(Kilowatts::class, $power->uom());
    }

    public function testToWattHoursDefaultsToOneHour(): void
    {
        $energy = Power::watts(100)->toWattHours();

        self::assertTrue($energy->value()->isEqualTo(BigDecimal::of('100')));
        self::assertInstanceOf(WattHours::class, $energy->uom());
    }

    public function testToWattHoursWithCustomDuration(): void
    {
        $energy = Power::watts(100)->toWattHours(Time::hours(2.5));

        self::assertEqualsWithDelta(250.0, (float) (string) $energy->value(), 0.01);
        self::assertInstanceOf(WattHours::class, $energy->uom());
    }

    public function testToWattHoursWithTimeDuration(): void
    {
        $energy = Power::watts(100)->toWattHours(Time::hours(3));

        self::assertEqualsWithDelta(300.0, (float) (string) $energy->value(), 0.01);
        self::assertInstanceOf(WattHours::class, $energy->uom());
    }
}
