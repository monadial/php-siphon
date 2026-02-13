<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Mechanics;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Exception\ParseFailure;
use Monadial\Siphon\Exception\UnitNotFound;
use Monadial\Siphon\Parsing\AliasGenerator;
use Monadial\Siphon\Parsing\QuantityParser;
use Monadial\Siphon\Parsing\UnitRegistry;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\Energy;
use Monadial\Siphon\Unit\Mechanics\Energy\BritishThermalUnits;
use Monadial\Siphon\Unit\Mechanics\Energy\Calories;
use Monadial\Siphon\Unit\Mechanics\Energy\Electronvolts;
use Monadial\Siphon\Unit\Mechanics\Energy\Gigajoules;
use Monadial\Siphon\Unit\Mechanics\Energy\GigawattHours;
use Monadial\Siphon\Unit\Mechanics\Energy\Joules;
use Monadial\Siphon\Unit\Mechanics\Energy\Kilocalories;
use Monadial\Siphon\Unit\Mechanics\Energy\Kilojoules;
use Monadial\Siphon\Unit\Mechanics\Energy\KilowattHours;
use Monadial\Siphon\Unit\Mechanics\Energy\Megajoules;
use Monadial\Siphon\Unit\Mechanics\Energy\MegawattHours;
use Monadial\Siphon\Unit\Mechanics\Energy\Millijoules;
use Monadial\Siphon\Unit\Mechanics\Energy\WattHours;
use Monadial\Siphon\Unit\Mechanics\EnergyUnit;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Energy::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(EnergyUnit::class)]
#[UsesClass(Joules::class)]
#[UsesClass(Millijoules::class)]
#[UsesClass(Kilojoules::class)]
#[UsesClass(Megajoules::class)]
#[UsesClass(Gigajoules::class)]
#[UsesClass(WattHours::class)]
#[UsesClass(KilowattHours::class)]
#[UsesClass(MegawattHours::class)]
#[UsesClass(GigawattHours::class)]
#[UsesClass(Calories::class)]
#[UsesClass(Kilocalories::class)]
#[UsesClass(BritishThermalUnits::class)]
#[UsesClass(Electronvolts::class)]
#[UsesClass(AliasGenerator::class)]
#[UsesClass(QuantityParser::class)]
#[UsesClass(UnitRegistry::class)]
final class EnergyTest extends TestCase
{
    // ---------------------------------------------------------------
    // Identity conversions
    // ---------------------------------------------------------------

    public function testIdentityJoules(): void
    {
        $e = new Energy(BigDecimal::of('1000'), Joules::make());
        $result = $e->toJoules();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
        self::assertInstanceOf(Joules::class, $result->uom());
    }

    // ---------------------------------------------------------------
    // Metric conversions (exact)
    // ---------------------------------------------------------------

    public function testJoulesToMillijoules(): void
    {
        $e = new Energy(BigDecimal::of('1'), Joules::make());
        $result = $e->toMillijoules();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
        self::assertInstanceOf(Millijoules::class, $result->uom());
    }

    public function testMillijoulesToJoules(): void
    {
        $e = new Energy(BigDecimal::of('1000'), Millijoules::make());
        $result = $e->toJoules();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testJoulesToKilojoules(): void
    {
        $e = new Energy(BigDecimal::of('1000'), Joules::make());
        $result = $e->toKilojoules();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(Kilojoules::class, $result->uom());
    }

    public function testKilojoulesToJoules(): void
    {
        $e = new Energy(BigDecimal::of('1'), Kilojoules::make());
        $result = $e->toJoules();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testJoulesToMegajoules(): void
    {
        $e = new Energy(BigDecimal::of('1000000'), Joules::make());
        $result = $e->toMegajoules();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(Megajoules::class, $result->uom());
    }

    public function testJoulesToGigajoules(): void
    {
        $e = new Energy(BigDecimal::of('1000000000'), Joules::make());
        $result = $e->toGigajoules();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(Gigajoules::class, $result->uom());
    }

    // ---------------------------------------------------------------
    // Watt-hour conversions
    // ---------------------------------------------------------------

    public function testJoulesToWattHours(): void
    {
        $e = new Energy(BigDecimal::of('3600'), Joules::make());
        $result = $e->toWattHours();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(WattHours::class, $result->uom());
    }

    public function testWattHoursToJoules(): void
    {
        $e = new Energy(BigDecimal::of('1'), WattHours::make());
        $result = $e->toJoules();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('3600')));
    }

    public function testJoulesToKilowattHours(): void
    {
        $e = new Energy(BigDecimal::of('3600000'), Joules::make());
        $result = $e->toKilowattHours();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(KilowattHours::class, $result->uom());
    }

    public function testKilowattHoursToJoules(): void
    {
        $e = new Energy(BigDecimal::of('1'), KilowattHours::make());
        $result = $e->toJoules();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('3600000')));
    }

    public function testJoulesToMegawattHours(): void
    {
        $e = new Energy(BigDecimal::of('3600000000'), Joules::make());
        $result = $e->toMegawattHours();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(MegawattHours::class, $result->uom());
    }

    public function testJoulesToGigawattHours(): void
    {
        $e = new Energy(BigDecimal::of('3600000000000'), Joules::make());
        $result = $e->toGigawattHours();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(GigawattHours::class, $result->uom());
    }

    // ---------------------------------------------------------------
    // Calorie conversions (approximate)
    // ---------------------------------------------------------------

    public function testJoulesToCalories(): void
    {
        $e = new Energy(BigDecimal::of('4.184'), Joules::make());
        $result = $e->toCalories();

        self::assertEqualsWithDelta(1.0, (float) (string) $result->value(), 0.0001);
        self::assertInstanceOf(Calories::class, $result->uom());
    }

    public function testCaloriesToJoules(): void
    {
        $e = new Energy(BigDecimal::of('1'), Calories::make());
        $result = $e->toJoules();

        self::assertEqualsWithDelta(4.184, (float) (string) $result->value(), 0.001);
    }

    public function testJoulesToKilocalories(): void
    {
        $e = new Energy(BigDecimal::of('4184'), Joules::make());
        $result = $e->toKilocalories();

        self::assertEqualsWithDelta(1.0, (float) (string) $result->value(), 0.0001);
        self::assertInstanceOf(Kilocalories::class, $result->uom());
    }

    public function testKilocaloriesToJoules(): void
    {
        $e = new Energy(BigDecimal::of('1'), Kilocalories::make());
        $result = $e->toJoules();

        self::assertEqualsWithDelta(4184.0, (float) (string) $result->value(), 0.1);
    }

    // ---------------------------------------------------------------
    // BTU conversions (approximate)
    // ---------------------------------------------------------------

    public function testJoulesToBritishThermalUnits(): void
    {
        $e = new Energy(BigDecimal::of('1055.05585262'), Joules::make());
        $result = $e->toBritishThermalUnits();

        self::assertEqualsWithDelta(1.0, (float) (string) $result->value(), 0.0001);
        self::assertInstanceOf(BritishThermalUnits::class, $result->uom());
    }

    public function testBritishThermalUnitsToJoules(): void
    {
        $e = new Energy(BigDecimal::of('1'), BritishThermalUnits::make());
        $result = $e->toJoules();

        self::assertEqualsWithDelta(1055.056, (float) (string) $result->value(), 0.1);
    }

    // ---------------------------------------------------------------
    // Electronvolt conversions
    // ---------------------------------------------------------------

    public function testJoulesToElectronvolts(): void
    {
        $e = new Energy(BigDecimal::of('1'), Joules::make());
        $result = $e->toElectronvolts();

        self::assertEqualsWithDelta(6.242e18, (float) (string) $result->value(), 1e15);
        self::assertInstanceOf(Electronvolts::class, $result->uom());
    }

    // ---------------------------------------------------------------
    // Zero value
    // ---------------------------------------------------------------

    public function testZeroValueConversion(): void
    {
        $e = new Energy(BigDecimal::of('0'), Joules::make());
        $result = $e->toKilowattHours();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0')));
    }

    // ---------------------------------------------------------------
    // Round-trip
    // ---------------------------------------------------------------

    public function testRoundTripJoulesToKilowattHours(): void
    {
        $original = new Energy(BigDecimal::of('7200000'), Joules::make());
        $converted = $original->toKilowattHours();
        $roundTrip = $converted->toJoules();

        self::assertTrue($roundTrip->value()->isEqualTo(BigDecimal::of('7200000')));
    }

    public function testRoundTripJoulesToCalories(): void
    {
        $original = new Energy(BigDecimal::of('1000'), Joules::make());
        $converted = $original->toCalories();
        $roundTrip = $converted->toJoules();

        self::assertEqualsWithDelta(1000.0, (float) (string) $roundTrip->value(), 0.001);
    }

    // ---------------------------------------------------------------
    // Return type checks
    // ---------------------------------------------------------------

    public function testScaleToReturnsEnergyInstance(): void
    {
        $e = new Energy(BigDecimal::of('1'), Joules::make());
        $result = $e->toKilojoules();

        self::assertInstanceOf(Energy::class, $result);
    }

    public function testStringUsesEnergySymbols(): void
    {
        self::assertSame('1 kWh', (string) Energy::kilowattHours(1));
        self::assertSame('1 J', (string) Energy::joules(1));
        self::assertSame('1 eV', (string) Energy::electronvolts(1));
        self::assertSame('1 Btu', (string) Energy::britishThermalUnits(1));
    }

    /**
     * @throws ParseFailure
     * @throws UnitNotFound
     */
    public function testParseEnergyFromSymbolString(): void
    {
        $energy = Energy::parse('100kWh');
        $joules = $energy->toJoules();

        self::assertInstanceOf(KilowattHours::class, $energy->uom());
        self::assertTrue($energy->value()->isEqualTo(BigDecimal::of('100')));
        self::assertTrue($joules->value()->isEqualTo(BigDecimal::of('360000000')));
    }

    /**
     * @throws ParseFailure
     * @throws UnitNotFound
     */
    public function testParseEnergyFromNameString(): void
    {
        $energy = Energy::parse('2.5 mega joules');

        self::assertInstanceOf(Megajoules::class, $energy->uom());
        self::assertTrue($energy->value()->isEqualTo(BigDecimal::of('2.5')));
        self::assertSame('2.5 MJ', (string) $energy);
    }

    // ---------------------------------------------------------------
    // Factory method coverage (plural forms)
    // ---------------------------------------------------------------

    public function testFactoryBritishThermalUnits(): void
    {
        self::assertInstanceOf(BritishThermalUnits::class, Energy::britishThermalUnits(1)->uom());
    }

    public function testFactoryCalories(): void
    {
        self::assertInstanceOf(Calories::class, Energy::calories(1)->uom());
    }

    public function testFactoryElectronvolts(): void
    {
        self::assertInstanceOf(Electronvolts::class, Energy::electronvolts(1)->uom());
    }

    public function testFactoryGigajoules(): void
    {
        self::assertInstanceOf(Gigajoules::class, Energy::gigajoules(1)->uom());
    }

    public function testFactoryGigawattHours(): void
    {
        self::assertInstanceOf(GigawattHours::class, Energy::gigawattHours(1)->uom());
    }

    public function testFactoryJoules(): void
    {
        self::assertInstanceOf(Joules::class, Energy::joules(1)->uom());
    }

    public function testFactoryKilocalories(): void
    {
        self::assertInstanceOf(Kilocalories::class, Energy::kilocalories(1)->uom());
    }

    public function testFactoryKilojoules(): void
    {
        self::assertInstanceOf(Kilojoules::class, Energy::kilojoules(1)->uom());
    }

    public function testFactoryKilowattHours(): void
    {
        self::assertInstanceOf(KilowattHours::class, Energy::kilowattHours(1)->uom());
    }

    public function testFactoryMegajoules(): void
    {
        self::assertInstanceOf(Megajoules::class, Energy::megajoules(1)->uom());
    }

    public function testFactoryMegawattHours(): void
    {
        self::assertInstanceOf(MegawattHours::class, Energy::megawattHours(1)->uom());
    }

    public function testFactoryMillijoules(): void
    {
        self::assertInstanceOf(Millijoules::class, Energy::millijoules(1)->uom());
    }

    public function testFactoryWattHours(): void
    {
        self::assertInstanceOf(WattHours::class, Energy::wattHours(1)->uom());
    }

    // ---------------------------------------------------------------
    // Factory method coverage (singular forms)
    // ---------------------------------------------------------------

    public function testFactoryBritishThermalUnit(): void
    {
        self::assertInstanceOf(BritishThermalUnits::class, Energy::britishThermalUnit(1)->uom());
    }

    public function testFactoryCalorie(): void
    {
        self::assertInstanceOf(Calories::class, Energy::calorie(1)->uom());
    }

    public function testFactoryElectronvolt(): void
    {
        self::assertInstanceOf(Electronvolts::class, Energy::electronvolt(1)->uom());
    }

    public function testFactoryGigajoule(): void
    {
        self::assertInstanceOf(Gigajoules::class, Energy::gigajoule(1)->uom());
    }

    public function testFactoryGigawattHour(): void
    {
        self::assertInstanceOf(GigawattHours::class, Energy::gigawattHour(1)->uom());
    }

    public function testFactoryJoule(): void
    {
        self::assertInstanceOf(Joules::class, Energy::joule(1)->uom());
    }

    public function testFactoryKilocalorie(): void
    {
        self::assertInstanceOf(Kilocalories::class, Energy::kilocalorie(1)->uom());
    }

    public function testFactoryKilojoule(): void
    {
        self::assertInstanceOf(Kilojoules::class, Energy::kilojoule(1)->uom());
    }

    public function testFactoryKilowattHour(): void
    {
        self::assertInstanceOf(KilowattHours::class, Energy::kilowattHour(1)->uom());
    }

    public function testFactoryMegajoule(): void
    {
        self::assertInstanceOf(Megajoules::class, Energy::megajoule(1)->uom());
    }

    public function testFactoryMegawattHour(): void
    {
        self::assertInstanceOf(MegawattHours::class, Energy::megawattHour(1)->uom());
    }

    public function testFactoryMillijoule(): void
    {
        self::assertInstanceOf(Millijoules::class, Energy::millijoule(1)->uom());
    }

    public function testFactoryWattHour(): void
    {
        self::assertInstanceOf(WattHours::class, Energy::wattHour(1)->uom());
    }

    // ---------------------------------------------------------------
    // Conversion method coverage
    // ---------------------------------------------------------------

    public function testToJoulesReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(Joules::class, Energy::kilojoules(1)->toJoules()->uom());
    }

    public function testToMillijoulesReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(Millijoules::class, Energy::joules(1)->toMillijoules()->uom());
    }

    public function testToKilojoulesReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(Kilojoules::class, Energy::joules(1000)->toKilojoules()->uom());
    }

    public function testToMegajoulesReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(Megajoules::class, Energy::joules(1000000)->toMegajoules()->uom());
    }

    public function testToGigajoulesReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(Gigajoules::class, Energy::joules(1000000000)->toGigajoules()->uom());
    }

    public function testToWattHoursReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(WattHours::class, Energy::joules(3600)->toWattHours()->uom());
    }

    public function testToKilowattHoursReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(KilowattHours::class, Energy::joules(3600000)->toKilowattHours()->uom());
    }

    public function testToMegawattHoursReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(MegawattHours::class, Energy::joules(3600000000)->toMegawattHours()->uom());
    }

    public function testToGigawattHoursReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(GigawattHours::class, Energy::joules('3600000000000')->toGigawattHours()->uom());
    }

    public function testToCaloriesReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(Calories::class, Energy::joules(100)->toCalories()->uom());
    }

    public function testToKilocaloriesReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(Kilocalories::class, Energy::joules(10000)->toKilocalories()->uom());
    }

    public function testToBritishThermalUnitsReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(BritishThermalUnits::class, Energy::joules(1055)->toBritishThermalUnits()->uom());
    }

    public function testToElectronvoltsReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(Electronvolts::class, Energy::joules(1)->toElectronvolts()->uom());
    }
}
