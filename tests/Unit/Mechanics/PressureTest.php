<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Mechanics;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\Pressure;
use Monadial\Siphon\Unit\Mechanics\Pressure\Atmospheres;
use Monadial\Siphon\Unit\Mechanics\Pressure\Bars;
use Monadial\Siphon\Unit\Mechanics\Pressure\Kilopascals;
use Monadial\Siphon\Unit\Mechanics\Pressure\Megapascals;
use Monadial\Siphon\Unit\Mechanics\Pressure\Millibars;
use Monadial\Siphon\Unit\Mechanics\Pressure\MillimetersOfMercury;
use Monadial\Siphon\Unit\Mechanics\Pressure\Pascals;
use Monadial\Siphon\Unit\Mechanics\Pressure\PoundsPerSquareInch;
use Monadial\Siphon\Unit\Mechanics\Pressure\Torr;
use Monadial\Siphon\Unit\Mechanics\PressureUnit;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Pressure::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(PressureUnit::class)]
#[UsesClass(Pascals::class)]
#[UsesClass(Kilopascals::class)]
#[UsesClass(Megapascals::class)]
#[UsesClass(Bars::class)]
#[UsesClass(Millibars::class)]
#[UsesClass(Atmospheres::class)]
#[UsesClass(PoundsPerSquareInch::class)]
#[UsesClass(Torr::class)]
#[UsesClass(MillimetersOfMercury::class)]
final class PressureTest extends TestCase
{
    // ---------------------------------------------------------------
    // Identity conversions
    // ---------------------------------------------------------------

    public function testIdentityPascals(): void
    {
        $p = new Pressure(BigDecimal::of('101325'), Pascals::make());
        $result = $p->toPascals();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('101325')));
        self::assertInstanceOf(Pascals::class, $result->uom());
    }

    // ---------------------------------------------------------------
    // Metric conversions (exact)
    // ---------------------------------------------------------------

    public function testPascalsToKilopascals(): void
    {
        $p = new Pressure(BigDecimal::of('1000'), Pascals::make());
        $result = $p->toKilopascals();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(Kilopascals::class, $result->uom());
    }

    public function testKilopascalsToPascals(): void
    {
        $p = new Pressure(BigDecimal::of('1'), Kilopascals::make());
        $result = $p->toPascals();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testPascalsToMegapascals(): void
    {
        $p = new Pressure(BigDecimal::of('1000000'), Pascals::make());
        $result = $p->toMegapascals();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(Megapascals::class, $result->uom());
    }

    public function testMegapascalsToPascals(): void
    {
        $p = new Pressure(BigDecimal::of('1'), Megapascals::make());
        $result = $p->toPascals();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    // ---------------------------------------------------------------
    // Bar conversions
    // ---------------------------------------------------------------

    public function testPascalsToBars(): void
    {
        $p = new Pressure(BigDecimal::of('100000'), Pascals::make());
        $result = $p->toBars();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(Bars::class, $result->uom());
    }

    public function testBarsToPascals(): void
    {
        $p = new Pressure(BigDecimal::of('1'), Bars::make());
        $result = $p->toPascals();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('100000')));
    }

    public function testPascalsToMillibars(): void
    {
        $p = new Pressure(BigDecimal::of('100'), Pascals::make());
        $result = $p->toMillibars();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(Millibars::class, $result->uom());
    }

    public function testMillibarsToPascals(): void
    {
        $p = new Pressure(BigDecimal::of('1'), Millibars::make());
        $result = $p->toPascals();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('100')));
    }

    // ---------------------------------------------------------------
    // Atmosphere conversions
    // ---------------------------------------------------------------

    public function testPascalsToAtmospheres(): void
    {
        $p = new Pressure(BigDecimal::of('101325'), Pascals::make());
        $result = $p->toAtmospheres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(Atmospheres::class, $result->uom());
    }

    public function testAtmospheresToPascals(): void
    {
        $p = new Pressure(BigDecimal::of('1'), Atmospheres::make());
        $result = $p->toPascals();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('101325')));
    }

    // ---------------------------------------------------------------
    // PSI conversions (approximate)
    // ---------------------------------------------------------------

    public function testPascalsToPoundsPerSquareInch(): void
    {
        $p = new Pressure(BigDecimal::of('6894.757293168'), Pascals::make());
        $result = $p->toPoundsPerSquareInch();

        self::assertEqualsWithDelta(1.0, (float) (string) $result->value(), 0.0001);
        self::assertInstanceOf(PoundsPerSquareInch::class, $result->uom());
    }

    public function testPoundsPerSquareInchToPascals(): void
    {
        $p = new Pressure(BigDecimal::of('1'), PoundsPerSquareInch::make());
        $result = $p->toPascals();

        self::assertEqualsWithDelta(6894.757, (float) (string) $result->value(), 0.01);
    }

    // ---------------------------------------------------------------
    // Torr conversions (approximate)
    // ---------------------------------------------------------------

    public function testPascalsToTorr(): void
    {
        $p = new Pressure(BigDecimal::of('133.32236842105263158'), Pascals::make());
        $result = $p->toTorr();

        self::assertEqualsWithDelta(1.0, (float) (string) $result->value(), 0.0001);
        self::assertInstanceOf(Torr::class, $result->uom());
    }

    public function testTorrToPascals(): void
    {
        $p = new Pressure(BigDecimal::of('760'), Torr::make());
        $result = $p->toPascals();

        self::assertEqualsWithDelta(101325.0, (float) (string) $result->value(), 0.1);
    }

    // ---------------------------------------------------------------
    // mmHg conversions (approximate)
    // ---------------------------------------------------------------

    public function testPascalsToMillimetersOfMercury(): void
    {
        $p = new Pressure(BigDecimal::of('133.322387415'), Pascals::make());
        $result = $p->toMillimetersOfMercury();

        self::assertEqualsWithDelta(1.0, (float) (string) $result->value(), 0.0001);
        self::assertInstanceOf(MillimetersOfMercury::class, $result->uom());
    }

    public function testMillimetersOfMercuryToPascals(): void
    {
        $p = new Pressure(BigDecimal::of('1'), MillimetersOfMercury::make());
        $result = $p->toPascals();

        self::assertEqualsWithDelta(133.322, (float) (string) $result->value(), 0.01);
    }

    // ---------------------------------------------------------------
    // Cross-conversions
    // ---------------------------------------------------------------

    public function testAtmospheresToBars(): void
    {
        $p = new Pressure(BigDecimal::of('1'), Atmospheres::make());
        $result = $p->toBars();

        self::assertEqualsWithDelta(1.01325, (float) (string) $result->value(), 0.0001);
    }

    public function testAtmospheresToTorr(): void
    {
        $p = new Pressure(BigDecimal::of('1'), Atmospheres::make());
        $result = $p->toTorr();

        self::assertEqualsWithDelta(760.0, (float) (string) $result->value(), 0.01);
    }

    public function testAtmospheresToPoundsPerSquareInch(): void
    {
        $p = new Pressure(BigDecimal::of('1'), Atmospheres::make());
        $result = $p->toPoundsPerSquareInch();

        self::assertEqualsWithDelta(14.696, (float) (string) $result->value(), 0.01);
    }

    // ---------------------------------------------------------------
    // Zero value
    // ---------------------------------------------------------------

    public function testZeroValueConversion(): void
    {
        $p = new Pressure(BigDecimal::of('0'), Pascals::make());
        $result = $p->toAtmospheres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0')));
    }

    // ---------------------------------------------------------------
    // Round-trip
    // ---------------------------------------------------------------

    public function testRoundTripPascalsToAtmospheres(): void
    {
        $original = new Pressure(BigDecimal::of('101325'), Pascals::make());
        $converted = $original->toAtmospheres();
        $roundTrip = $converted->toPascals();

        self::assertTrue($roundTrip->value()->isEqualTo(BigDecimal::of('101325')));
    }

    public function testRoundTripPascalsToPoundsPerSquareInch(): void
    {
        $original = new Pressure(BigDecimal::of('50000'), Pascals::make());
        $converted = $original->toPoundsPerSquareInch();
        $roundTrip = $converted->toPascals();

        self::assertEqualsWithDelta(50000.0, (float) (string) $roundTrip->value(), 0.01);
    }

    // ---------------------------------------------------------------
    // Return type checks
    // ---------------------------------------------------------------

    public function testScaleToReturnsPressureInstance(): void
    {
        $p = new Pressure(BigDecimal::of('1'), Pascals::make());
        $result = $p->toKilopascals();

        self::assertInstanceOf(Pressure::class, $result);
    }

    // ---------------------------------------------------------------
    // Factory method coverage (plural forms)
    // ---------------------------------------------------------------

    public function testFactoryAtmospheres(): void
    {
        self::assertInstanceOf(Atmospheres::class, Pressure::atmospheres(1)->uom());
    }

    public function testFactoryBars(): void
    {
        self::assertInstanceOf(Bars::class, Pressure::bars(1)->uom());
    }

    public function testFactoryKilopascals(): void
    {
        self::assertInstanceOf(Kilopascals::class, Pressure::kilopascals(1)->uom());
    }

    public function testFactoryMegapascals(): void
    {
        self::assertInstanceOf(Megapascals::class, Pressure::megapascals(1)->uom());
    }

    public function testFactoryMillibars(): void
    {
        self::assertInstanceOf(Millibars::class, Pressure::millibars(1)->uom());
    }

    public function testFactoryMillimetersOfMercury(): void
    {
        self::assertInstanceOf(MillimetersOfMercury::class, Pressure::millimetersOfMercury(1)->uom());
    }

    public function testFactoryPascals(): void
    {
        self::assertInstanceOf(Pascals::class, Pressure::pascals(1)->uom());
    }

    public function testFactoryPoundsPerSquareInch(): void
    {
        self::assertInstanceOf(PoundsPerSquareInch::class, Pressure::poundsPerSquareInch(1)->uom());
    }

    public function testFactoryTorr(): void
    {
        self::assertInstanceOf(Torr::class, Pressure::torr(1)->uom());
    }

    // ---------------------------------------------------------------
    // Factory method coverage (singular forms)
    // ---------------------------------------------------------------

    public function testFactoryAtmosphere(): void
    {
        self::assertInstanceOf(Atmospheres::class, Pressure::atmosphere(1)->uom());
    }

    public function testFactoryBar(): void
    {
        self::assertInstanceOf(Bars::class, Pressure::bar(1)->uom());
    }

    public function testFactoryKilopascal(): void
    {
        self::assertInstanceOf(Kilopascals::class, Pressure::kilopascal(1)->uom());
    }

    public function testFactoryMegapascal(): void
    {
        self::assertInstanceOf(Megapascals::class, Pressure::megapascal(1)->uom());
    }

    public function testFactoryMillibar(): void
    {
        self::assertInstanceOf(Millibars::class, Pressure::millibar(1)->uom());
    }

    public function testFactoryPascal(): void
    {
        self::assertInstanceOf(Pascals::class, Pressure::pascal(1)->uom());
    }

    // ---------------------------------------------------------------
    // Conversion method coverage
    // ---------------------------------------------------------------

    public function testToPascalsReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(Pascals::class, Pressure::kilopascals(1)->toPascals()->uom());
    }

    public function testToKilopascalsReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(Kilopascals::class, Pressure::pascals(1000)->toKilopascals()->uom());
    }

    public function testToMegapascalsReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(Megapascals::class, Pressure::pascals(1000000)->toMegapascals()->uom());
    }

    public function testToBarsReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(Bars::class, Pressure::pascals(100000)->toBars()->uom());
    }

    public function testToMillibarsReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(Millibars::class, Pressure::pascals(100)->toMillibars()->uom());
    }

    public function testToAtmospheresReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(Atmospheres::class, Pressure::pascals(101325)->toAtmospheres()->uom());
    }

    public function testToPoundsPerSquareInchReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(PoundsPerSquareInch::class, Pressure::pascals(6895)->toPoundsPerSquareInch()->uom());
    }

    public function testToTorrReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(Torr::class, Pressure::pascals(133)->toTorr()->uom());
    }

    public function testToMillimetersOfMercuryReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(MillimetersOfMercury::class, Pressure::pascals(133)->toMillimetersOfMercury()->uom());
    }
}
