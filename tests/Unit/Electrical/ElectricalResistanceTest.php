<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Electrical;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance\Gigohms;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance\Kilohms;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance\Megohms;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance\Microhms;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance\Milliohms;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance\Nanohms;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance\Ohms;
use Monadial\Siphon\Unit\Electrical\ElectricalResistanceUnit;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ElectricalResistance::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(Ohms::class)]
#[UsesClass(Nanohms::class)]
#[UsesClass(Microhms::class)]
#[UsesClass(Milliohms::class)]
#[UsesClass(Kilohms::class)]
#[UsesClass(Megohms::class)]
#[UsesClass(Gigohms::class)]
#[UsesClass(ElectricalResistanceUnit::class)]
final class ElectricalResistanceTest extends TestCase
{
    // ---------------------------------------------------------------
    // Construction and basic accessors
    // ---------------------------------------------------------------

    public function testConstructionAndValueAccess(): void
    {
        $resistance = new ElectricalResistance(BigDecimal::of('100'), Ohms::make());

        self::assertTrue($resistance->value()->isEqualTo(BigDecimal::of('100')));
        self::assertInstanceOf(Ohms::class, $resistance->uom());
    }

    // ---------------------------------------------------------------
    // Identity conversions
    // ---------------------------------------------------------------

    public function testIdentityConversion(): void
    {
        $resistance = new ElectricalResistance(BigDecimal::of('47'), Ohms::make());
        $result = $resistance->toOhms();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('47')));
    }

    // ---------------------------------------------------------------
    // Ohms to other units
    // ---------------------------------------------------------------

    public function testOhmsToMilliohms(): void
    {
        $resistance = new ElectricalResistance(BigDecimal::of('1'), Ohms::make());
        $result = $resistance->toMilliohms();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testOhmsToMicrohms(): void
    {
        $resistance = new ElectricalResistance(BigDecimal::of('1'), Ohms::make());
        $result = $resistance->toMicrohms();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    public function testOhmsToNanohms(): void
    {
        $resistance = new ElectricalResistance(BigDecimal::of('1'), Ohms::make());
        $result = $resistance->toNanohms();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000000')));
    }

    public function testOhmsToKilohms(): void
    {
        $resistance = new ElectricalResistance(BigDecimal::of('1000'), Ohms::make());
        $result = $resistance->toKilohms();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testOhmsToMegohms(): void
    {
        $resistance = new ElectricalResistance(BigDecimal::of('1000000'), Ohms::make());
        $result = $resistance->toMegohms();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testOhmsToGigohms(): void
    {
        $resistance = new ElectricalResistance(BigDecimal::of('1000000000'), Ohms::make());
        $result = $resistance->toGigohms();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    // ---------------------------------------------------------------
    // Other units to ohms
    // ---------------------------------------------------------------

    public function testMilliohmsToOhms(): void
    {
        $resistance = new ElectricalResistance(BigDecimal::of('500'), Milliohms::make());
        $result = $resistance->toOhms();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.5')));
    }

    public function testKilohmsToOhms(): void
    {
        $resistance = new ElectricalResistance(BigDecimal::of('4.7'), Kilohms::make());
        $result = $resistance->toOhms();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('4700')));
    }

    public function testMegohmsToOhms(): void
    {
        $resistance = new ElectricalResistance(BigDecimal::of('1'), Megohms::make());
        $result = $resistance->toOhms();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    public function testGigohmsToOhms(): void
    {
        $resistance = new ElectricalResistance(BigDecimal::of('1'), Gigohms::make());
        $result = $resistance->toOhms();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000000')));
    }

    // ---------------------------------------------------------------
    // Cross-conversions
    // ---------------------------------------------------------------

    public function testKilohmsToMilliohms(): void
    {
        $resistance = new ElectricalResistance(BigDecimal::of('1'), Kilohms::make());
        $result = $resistance->toMilliohms();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    public function testNanohmsToMicrohms(): void
    {
        $resistance = new ElectricalResistance(BigDecimal::of('1000'), Nanohms::make());
        $result = $resistance->toMicrohms();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testGigohmsToKilohms(): void
    {
        $resistance = new ElectricalResistance(BigDecimal::of('1'), Gigohms::make());
        $result = $resistance->toKilohms();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    // ---------------------------------------------------------------
    // Round-trip conversions
    // ---------------------------------------------------------------

    public function testRoundTripOhmsToGigohmsAndBack(): void
    {
        $original = new ElectricalResistance(BigDecimal::of('5000000000'), Ohms::make());
        $converted = $original->toGigohms();
        $roundTrip = $converted->toOhms();

        self::assertTrue($roundTrip->value()->isEqualTo(BigDecimal::of('5000000000')));
    }

    public function testRoundTripMilliohmsToMegohmsAndBack(): void
    {
        $original = new ElectricalResistance(BigDecimal::of('1000000000'), Milliohms::make());
        $converted = $original->toMegohms();
        $roundTrip = $converted->toMilliohms();

        self::assertTrue($roundTrip->value()->isEqualTo(BigDecimal::of('1000000000')));
    }

    // ---------------------------------------------------------------
    // Return type / instance checks
    // ---------------------------------------------------------------

    public function testScaleToReturnsElectricalResistanceInstance(): void
    {
        $resistance = new ElectricalResistance(BigDecimal::of('1'), Ohms::make());
        $result = $resistance->toKilohms();

        self::assertInstanceOf(ElectricalResistance::class, $result);
    }

    public function testConversionPreservesUnitOfMeasure(): void
    {
        $resistance = new ElectricalResistance(BigDecimal::of('1'), Ohms::make());

        self::assertInstanceOf(Nanohms::class, $resistance->toNanohms()->uom());
        self::assertInstanceOf(Microhms::class, $resistance->toMicrohms()->uom());
        self::assertInstanceOf(Milliohms::class, $resistance->toMilliohms()->uom());
        self::assertInstanceOf(Kilohms::class, $resistance->toKilohms()->uom());
        self::assertInstanceOf(Megohms::class, $resistance->toMegohms()->uom());
        self::assertInstanceOf(Gigohms::class, $resistance->toGigohms()->uom());
    }

    // ---------------------------------------------------------------
    // Zero value
    // ---------------------------------------------------------------

    public function testZeroValueConversion(): void
    {
        $resistance = new ElectricalResistance(BigDecimal::of('0'), Ohms::make());
        $result = $resistance->toKilohms();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0')));
    }

    // ---------------------------------------------------------------
    // Typed factory methods (plural forms)
    // ---------------------------------------------------------------

    public function testOhmsFactory(): void
    {
        self::assertInstanceOf(Ohms::class, ElectricalResistance::ohms(1)->uom());
    }

    public function testGigohmsFactory(): void
    {
        self::assertInstanceOf(Gigohms::class, ElectricalResistance::gigohms(1)->uom());
    }

    public function testKilohmsFactory(): void
    {
        self::assertInstanceOf(Kilohms::class, ElectricalResistance::kilohms(1)->uom());
    }

    public function testMegohmsFactory(): void
    {
        self::assertInstanceOf(Megohms::class, ElectricalResistance::megohms(1)->uom());
    }

    public function testMicrohmsFactory(): void
    {
        self::assertInstanceOf(Microhms::class, ElectricalResistance::microhms(1)->uom());
    }

    public function testMilliohmsFactory(): void
    {
        self::assertInstanceOf(Milliohms::class, ElectricalResistance::milliohms(1)->uom());
    }

    public function testNanohmsFactory(): void
    {
        self::assertInstanceOf(Nanohms::class, ElectricalResistance::nanohms(1)->uom());
    }

    // ---------------------------------------------------------------
    // Typed factory methods (singular forms)
    // ---------------------------------------------------------------

    public function testOhmFactory(): void
    {
        self::assertInstanceOf(Ohms::class, ElectricalResistance::ohm(1)->uom());
    }

    public function testGigohmFactory(): void
    {
        self::assertInstanceOf(Gigohms::class, ElectricalResistance::gigohm(1)->uom());
    }

    public function testKilohmFactory(): void
    {
        self::assertInstanceOf(Kilohms::class, ElectricalResistance::kilohm(1)->uom());
    }

    public function testMegohmFactory(): void
    {
        self::assertInstanceOf(Megohms::class, ElectricalResistance::megohm(1)->uom());
    }

    public function testMicrohmFactory(): void
    {
        self::assertInstanceOf(Microhms::class, ElectricalResistance::microhm(1)->uom());
    }

    public function testMilliohmFactory(): void
    {
        self::assertInstanceOf(Milliohms::class, ElectricalResistance::milliohm(1)->uom());
    }

    public function testNanohmFactory(): void
    {
        self::assertInstanceOf(Nanohms::class, ElectricalResistance::nanohm(1)->uom());
    }
}
