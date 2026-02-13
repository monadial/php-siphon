<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Space;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Exception\UnitNotFound;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Space\Length;
use Monadial\Siphon\Unit\Space\Length\AstronomicalUnits;
use Monadial\Siphon\Unit\Space\Length\Centimeters;
use Monadial\Siphon\Unit\Space\Length\Decameters;
use Monadial\Siphon\Unit\Space\Length\Decimeters;
use Monadial\Siphon\Unit\Space\Length\Feet;
use Monadial\Siphon\Unit\Space\Length\Hectometers;
use Monadial\Siphon\Unit\Space\Length\Inches;
use Monadial\Siphon\Unit\Space\Length\Kilometers;
use Monadial\Siphon\Unit\Space\Length\LightYears;
use Monadial\Siphon\Unit\Space\Length\Meters;
use Monadial\Siphon\Unit\Space\Length\Micrometers;
use Monadial\Siphon\Unit\Space\Length\Miles;
use Monadial\Siphon\Unit\Space\Length\Millimeters;
use Monadial\Siphon\Unit\Space\Length\Nanometers;
use Monadial\Siphon\Unit\Space\Length\NauticalMiles;
use Monadial\Siphon\Unit\Space\Length\Yards;
use Monadial\Siphon\Unit\Space\LengthUnit;
use Monadial\Siphon\Unit\Space\Volume;
use Monadial\Siphon\Unit\Space\Volume\CubicMeters;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Length::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(Nanometers::class)]
#[UsesClass(Micrometers::class)]
#[UsesClass(Millimeters::class)]
#[UsesClass(Centimeters::class)]
#[UsesClass(Decimeters::class)]
#[UsesClass(Meters::class)]
#[UsesClass(Decameters::class)]
#[UsesClass(Hectometers::class)]
#[UsesClass(Kilometers::class)]
#[UsesClass(Inches::class)]
#[UsesClass(Feet::class)]
#[UsesClass(Yards::class)]
#[UsesClass(Miles::class)]
#[UsesClass(NauticalMiles::class)]
#[UsesClass(AstronomicalUnits::class)]
#[UsesClass(LightYears::class)]
#[UsesClass(LengthUnit::class)]
#[UsesClass(Volume::class)]
#[UsesClass(CubicMeters::class)]
final class LengthTest extends TestCase
{
    // ---------------------------------------------------------------
    // Construction and basic accessors
    // ---------------------------------------------------------------

    /**
     * @return array<string, array{string, LengthUnit, LengthUnit, string}>
     */
    public static function conversionProvider(): array
    {
        return [
            '0.001 km = 1 m' => ['0.001', Kilometers::make(), Meters::make(), '1'],
            '1 dam = 10 m' => ['1', Decameters::make(), Meters::make(), '10'],
            '1 hm = 100 m' => ['1', Hectometers::make(), Meters::make(), '100'],
            '1 km = 1000 m' => ['1', Kilometers::make(), Meters::make(), '1000'],
            '1 km = 1000000 mm' => ['1', Kilometers::make(), Millimeters::make(), '1000000'],
            '1 m = 10 dm' => ['1', Meters::make(), Decimeters::make(), '10'],
            '1 m = 100 cm' => ['1', Meters::make(), Centimeters::make(), '100'],
            '1 m = 1000 mm' => ['1', Meters::make(), Millimeters::make(), '1000'],
            '1 m = 1000000 um' => ['1', Meters::make(), Micrometers::make(), '1000000'],
            '1 m = 1000000000 nm' => ['1', Meters::make(), Nanometers::make(), '1000000000'],
            '5.5 m = 5.5 m (identity)' => ['5.5', Meters::make(), Meters::make(), '5.5'],
            '500 cm = 5 m' => ['500', Centimeters::make(), Meters::make(), '5'],
            '2500 m = 2.5 km' => ['2500', Meters::make(), Kilometers::make(), '2.5'],
        ];
    }

    public function testConstructionAndValueAccess(): void
    {
        $length = new Length(BigDecimal::of('42'), Meters::make());

        self::assertTrue($length->value()->isEqualTo(BigDecimal::of('42')));
        self::assertInstanceOf(Meters::class, $length->uom());
    }

    public function testConstructionWithDecimalValue(): void
    {
        $length = new Length(BigDecimal::of('3.14159'), Meters::make());

        self::assertTrue($length->value()->isEqualTo(BigDecimal::of('3.14159')));
    }

    /** @throws UnitNotFound */
    public function testConstructionWithFromDsl(): void
    {
        $length = Meters::from(42);

        self::assertTrue($length->value()->isEqualTo(BigDecimal::of('42')));
        self::assertInstanceOf(Meters::class, $length->uom());
    }

    public function testStaticDslConstructionWithPluralUnitName(): void
    {
        $length = Length::meters(12);

        self::assertTrue($length->value()->isEqualTo(BigDecimal::of('12')));
        self::assertInstanceOf(Meters::class, $length->uom());
    }

    public function testStaticDslConstructionWithSingularUnitName(): void
    {
        $length = Length::meter(12);

        self::assertTrue($length->value()->isEqualTo(BigDecimal::of('12')));
        self::assertInstanceOf(Meters::class, $length->uom());
    }

    public function testTypedConversionToKilometers(): void
    {
        $length = Length::meters(1200)->toKilometers();

        self::assertTrue($length->value()->isEqualTo(BigDecimal::of('1.2')));
        self::assertInstanceOf(Kilometers::class, $length->uom());
    }

    public function testToCubicCreatesCubicMetersVolume(): void
    {
        $volume = Length::meters(12)->toCubic();

        self::assertTrue($volume->value()->isEqualTo(BigDecimal::of('1728')));
        self::assertInstanceOf(CubicMeters::class, $volume->uom());
    }

    public function testCubedAliasMatchesToCubic(): void
    {
        $volume = Length::meters(2)->cubed();

        self::assertTrue($volume->value()->isEqualTo(BigDecimal::of('8')));
        self::assertInstanceOf(CubicMeters::class, $volume->uom());
    }

    // ---------------------------------------------------------------
    // Identity conversion (same unit)
    // ---------------------------------------------------------------

    public function testIdentityConversionMetersToMeters(): void
    {
        $length = new Length(BigDecimal::of('5.5'), Meters::make());
        $result = $length->toMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5.5')));
        self::assertInstanceOf(Meters::class, $result->uom());
    }

    public function testIdentityConversionKilometersToKilometers(): void
    {
        $length = new Length(BigDecimal::of('12.345'), Kilometers::make());
        $result = $length->toKilometers();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('12.345')));
        self::assertInstanceOf(Kilometers::class, $result->uom());
    }

    public function testIdentityConversionMillimetersToMillimeters(): void
    {
        $length = new Length(BigDecimal::of('999'), Millimeters::make());
        $result = $length->toMillimeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('999')));
    }

    // ---------------------------------------------------------------
    // Meters to other units
    // ---------------------------------------------------------------

    public function testMetersToKilometers(): void
    {
        $length = new Length(BigDecimal::of('1000'), Meters::make());
        $result = $length->toKilometers();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(Kilometers::class, $result->uom());
    }

    public function testMetersToCentimeters(): void
    {
        $length = new Length(BigDecimal::of('1'), Meters::make());
        $result = $length->toCentimeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('100')));
        self::assertInstanceOf(Centimeters::class, $result->uom());
    }

    public function testMetersToMillimeters(): void
    {
        $length = new Length(BigDecimal::of('1'), Meters::make());
        $result = $length->toMillimeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
        self::assertInstanceOf(Millimeters::class, $result->uom());
    }

    public function testMetersToMicrometers(): void
    {
        $length = new Length(BigDecimal::of('1'), Meters::make());
        $result = $length->toMicrometers();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
        self::assertInstanceOf(Micrometers::class, $result->uom());
    }

    public function testMetersToNanometers(): void
    {
        $length = new Length(BigDecimal::of('1'), Meters::make());
        $result = $length->toNanometers();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000000')));
        self::assertInstanceOf(Nanometers::class, $result->uom());
    }

    public function testMetersToDecimeters(): void
    {
        $length = new Length(BigDecimal::of('1'), Meters::make());
        $result = $length->toDecimeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('10')));
        self::assertInstanceOf(Decimeters::class, $result->uom());
    }

    public function testMetersToDecameters(): void
    {
        $length = new Length(BigDecimal::of('10'), Meters::make());
        $result = $length->toDecameters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(Decameters::class, $result->uom());
    }

    public function testMetersToHectometers(): void
    {
        $length = new Length(BigDecimal::of('100'), Meters::make());
        $result = $length->toHectometers();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(Hectometers::class, $result->uom());
    }

    // ---------------------------------------------------------------
    // Other units back to meters
    // ---------------------------------------------------------------

    public function testKilometersToMeters(): void
    {
        $length = new Length(BigDecimal::of('1'), Kilometers::make());
        $result = $length->toMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
        self::assertInstanceOf(Meters::class, $result->uom());
    }

    public function testCentimetersToMeters(): void
    {
        $length = new Length(BigDecimal::of('100'), Centimeters::make());
        $result = $length->toMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testMillimetersToMeters(): void
    {
        $length = new Length(BigDecimal::of('1000'), Millimeters::make());
        $result = $length->toMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testNanometersToMeters(): void
    {
        $length = new Length(BigDecimal::of('1'), Nanometers::make());
        $result = $length->toMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.000000001')));
    }

    public function testMicrometersToMeters(): void
    {
        $length = new Length(BigDecimal::of('1000000'), Micrometers::make());
        $result = $length->toMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testDecimetersToMeters(): void
    {
        $length = new Length(BigDecimal::of('10'), Decimeters::make());
        $result = $length->toMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testDecametersToMeters(): void
    {
        $length = new Length(BigDecimal::of('1'), Decameters::make());
        $result = $length->toMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('10')));
    }

    public function testHectometersToMeters(): void
    {
        $length = new Length(BigDecimal::of('1'), Hectometers::make());
        $result = $length->toMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('100')));
    }

    // ---------------------------------------------------------------
    // Cross-conversions (not going through meters explicitly)
    // ---------------------------------------------------------------

    public function testKilometersToMillimeters(): void
    {
        $length = new Length(BigDecimal::of('1'), Kilometers::make());
        $result = $length->toMillimeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    public function testMillimetersToKilometers(): void
    {
        $length = new Length(BigDecimal::of('1000000'), Millimeters::make());
        $result = $length->toKilometers();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testCentimetersToMillimeters(): void
    {
        $length = new Length(BigDecimal::of('1'), Centimeters::make());
        $result = $length->toMillimeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('10')));
    }

    public function testMillimetersToCentimeters(): void
    {
        $length = new Length(BigDecimal::of('10'), Millimeters::make());
        $result = $length->toCentimeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testKilometersToCentimeters(): void
    {
        $length = new Length(BigDecimal::of('1'), Kilometers::make());
        $result = $length->toCentimeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('100000')));
    }

    public function testNanometersToMicrometers(): void
    {
        $length = new Length(BigDecimal::of('1000'), Nanometers::make());
        $result = $length->toMicrometers();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testDecimetersToHectometers(): void
    {
        $length = new Length(BigDecimal::of('1000'), Decimeters::make());
        $result = $length->toHectometers();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    // ---------------------------------------------------------------
    // Non-integer and fractional values
    // ---------------------------------------------------------------

    public function testFractionalMetersToKilometers(): void
    {
        $length = new Length(BigDecimal::of('2500'), Meters::make());
        $result = $length->toKilometers();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('2.5')));
    }

    public function testFractionalKilometersToMeters(): void
    {
        $length = new Length(BigDecimal::of('0.5'), Kilometers::make());
        $result = $length->toMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('500')));
    }

    public function testSmallDecimalCentimetersToMeters(): void
    {
        $length = new Length(BigDecimal::of('1.5'), Centimeters::make());
        $result = $length->toMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.015')));
    }

    // ---------------------------------------------------------------
    // Data-provider-based systematic conversion tests
    // ---------------------------------------------------------------


    #[DataProvider('conversionProvider')]
    public function testConversion(string $inputValue, LengthUnit $from, LengthUnit $to, string $expected): void
    {
        $length = new Length(BigDecimal::of($inputValue), $from);
        $result = $length->scaleTo($to);

        self::assertTrue(
            $result->value()->isEqualTo(BigDecimal::of($expected)),
            sprintf(
                'Expected %s but got %s when converting %s from %s to %s',
                $expected,
                (string) $result->value(),
                $inputValue,
                $from::class,
                $to::class,
            ),
        );
    }

    // ---------------------------------------------------------------
    // Precision / extreme values
    // ---------------------------------------------------------------

    public function testOneNanometerInMeters(): void
    {
        $length = new Length(BigDecimal::of('1'), Nanometers::make());
        $result = $length->toMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.000000001')));
    }

    public function testLargeValueConversion(): void
    {
        $length = new Length(BigDecimal::of('1000000000'), Nanometers::make());
        $result = $length->toMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testZeroValueConversion(): void
    {
        $length = new Length(BigDecimal::of('0'), Meters::make());
        $result = $length->toKilometers();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0')));
    }

    // ---------------------------------------------------------------
    // Return type / instance checks
    // ---------------------------------------------------------------

    public function testScaleToReturnsLengthInstance(): void
    {
        $length = new Length(BigDecimal::of('1'), Meters::make());
        $result = $length->toKilometers();

        self::assertInstanceOf(Length::class, $result);
    }

    public function testConversionPreservesUnitOfMeasure(): void
    {
        $length = new Length(BigDecimal::of('1'), Meters::make());

        self::assertInstanceOf(Centimeters::class, $length->toCentimeters()->uom());
        self::assertInstanceOf(Millimeters::class, $length->toMillimeters()->uom());
        self::assertInstanceOf(Kilometers::class, $length->toKilometers()->uom());
        self::assertInstanceOf(Nanometers::class, $length->toNanometers()->uom());
        self::assertInstanceOf(Micrometers::class, $length->toMicrometers()->uom());
        self::assertInstanceOf(Decimeters::class, $length->toDecimeters()->uom());
        self::assertInstanceOf(Decameters::class, $length->toDecameters()->uom());
        self::assertInstanceOf(Hectometers::class, $length->toHectometers()->uom());
    }

    // ---------------------------------------------------------------
    // Round-trip conversions
    // ---------------------------------------------------------------

    public function testRoundTripMetersToKilometersAndBack(): void
    {
        $original = new Length(BigDecimal::of('1234'), Meters::make());
        $converted = $original->toKilometers();
        $roundTrip = $converted->toMeters();

        self::assertTrue($roundTrip->value()->isEqualTo(BigDecimal::of('1234')));
    }

    public function testRoundTripCentimetersToNanometersAndBack(): void
    {
        $original = new Length(BigDecimal::of('50'), Centimeters::make());
        $converted = $original->toNanometers();
        $roundTrip = $converted->toCentimeters();

        self::assertTrue($roundTrip->value()->isEqualTo(BigDecimal::of('50')));
    }

    // ---------------------------------------------------------------
    // Imperial / customary unit conversions
    // ---------------------------------------------------------------

    public function testMetersToInches(): void
    {
        $length = new Length(BigDecimal::of('1'), Meters::make());
        $result = $length->toInches();

        self::assertEqualsWithDelta(39.3701, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(Inches::class, $result->uom());
    }

    public function testInchesToMeters(): void
    {
        $length = new Length(BigDecimal::of('1'), Inches::make());
        $result = $length->toMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.0254')));
    }

    public function testMetersToFeet(): void
    {
        $length = new Length(BigDecimal::of('1'), Meters::make());
        $result = $length->toFeet();

        self::assertEqualsWithDelta(3.28084, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(Feet::class, $result->uom());
    }

    public function testFeetToMeters(): void
    {
        $length = new Length(BigDecimal::of('1'), Feet::make());
        $result = $length->toMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.3048')));
    }

    public function testFeetToInches(): void
    {
        $length = new Length(BigDecimal::of('1'), Feet::make());
        $result = $length->toInches();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('12')));
    }

    public function testMetersToYards(): void
    {
        $length = new Length(BigDecimal::of('1'), Meters::make());
        $result = $length->toYards();

        self::assertEqualsWithDelta(1.09361, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(Yards::class, $result->uom());
    }

    public function testYardsToMeters(): void
    {
        $length = new Length(BigDecimal::of('1'), Yards::make());
        $result = $length->toMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.9144')));
    }

    public function testYardsToFeet(): void
    {
        $length = new Length(BigDecimal::of('1'), Yards::make());
        $result = $length->toFeet();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('3')));
    }

    public function testMilesToMeters(): void
    {
        $length = new Length(BigDecimal::of('1'), Miles::make());
        $result = $length->toMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1609.344')));
        self::assertInstanceOf(Meters::class, $result->uom());
    }

    public function testKilometersToMiles(): void
    {
        $length = new Length(BigDecimal::of('1'), Kilometers::make());
        $result = $length->toMiles();

        self::assertEqualsWithDelta(0.621371, (float) (string) $result->value(), 0.001);
    }

    public function testMilesToFeet(): void
    {
        $length = new Length(BigDecimal::of('1'), Miles::make());
        $result = $length->toFeet();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5280')));
    }

    public function testMilesToYards(): void
    {
        $length = new Length(BigDecimal::of('1'), Miles::make());
        $result = $length->toYards();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1760')));
    }

    public function testNauticalMilesToMeters(): void
    {
        $length = new Length(BigDecimal::of('1'), NauticalMiles::make());
        $result = $length->toMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1852')));
        self::assertInstanceOf(Meters::class, $result->uom());
    }

    public function testKilometersToNauticalMiles(): void
    {
        $length = new Length(BigDecimal::of('1.852'), Kilometers::make());
        $result = $length->toNauticalMiles();

        self::assertEqualsWithDelta(1.0, (float) (string) $result->value(), 0.001);
    }

    public function testAstronomicalUnitsToMeters(): void
    {
        $length = new Length(BigDecimal::of('1'), AstronomicalUnits::make());
        $result = $length->toMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('149597870700')));
        self::assertInstanceOf(Meters::class, $result->uom());
    }

    public function testAstronomicalUnitsToKilometers(): void
    {
        $length = new Length(BigDecimal::of('1'), AstronomicalUnits::make());
        $result = $length->toKilometers();

        self::assertEqualsWithDelta(149597870.7, (float) (string) $result->value(), 0.1);
    }

    public function testLightYearsToMeters(): void
    {
        $length = new Length(BigDecimal::of('1'), LightYears::make());
        $result = $length->toMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('9460730472580800')));
        self::assertInstanceOf(Meters::class, $result->uom());
    }

    public function testLightYearsToAstronomicalUnits(): void
    {
        $length = new Length(BigDecimal::of('1'), LightYears::make());
        $result = $length->toAstronomicalUnits();

        self::assertEqualsWithDelta(63241.077, (float) (string) $result->value(), 0.1);
    }

    // ---------------------------------------------------------------
    // Imperial identity conversions
    // ---------------------------------------------------------------

    public function testIdentityConversionInches(): void
    {
        $length = new Length(BigDecimal::of('12.5'), Inches::make());
        $result = $length->toInches();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('12.5')));
        self::assertInstanceOf(Inches::class, $result->uom());
    }

    public function testIdentityConversionMiles(): void
    {
        $length = new Length(BigDecimal::of('26.2'), Miles::make());
        $result = $length->toMiles();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('26.2')));
        self::assertInstanceOf(Miles::class, $result->uom());
    }

    // ---------------------------------------------------------------
    // Imperial round-trip conversions
    // ---------------------------------------------------------------

    public function testRoundTripMetersToInchesAndBack(): void
    {
        $original = new Length(BigDecimal::of('5'), Meters::make());
        $converted = $original->toInches();
        $roundTrip = $converted->toMeters();

        self::assertEqualsWithDelta(5.0, (float) (string) $roundTrip->value(), 0.0001);
    }

    public function testRoundTripKilometersToMilesAndBack(): void
    {
        $original = new Length(BigDecimal::of('100'), Kilometers::make());
        $converted = $original->toMiles();
        $roundTrip = $converted->toKilometers();

        self::assertEqualsWithDelta(100.0, (float) (string) $roundTrip->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // Imperial unit of measure preservation
    // ---------------------------------------------------------------

    public function testImperialConversionPreservesUnitOfMeasure(): void
    {
        $length = new Length(BigDecimal::of('1'), Meters::make());

        self::assertInstanceOf(Inches::class, $length->toInches()->uom());
        self::assertInstanceOf(Feet::class, $length->toFeet()->uom());
        self::assertInstanceOf(Yards::class, $length->toYards()->uom());
        self::assertInstanceOf(Miles::class, $length->toMiles()->uom());
        self::assertInstanceOf(NauticalMiles::class, $length->toNauticalMiles()->uom());
        self::assertInstanceOf(AstronomicalUnits::class, $length->toAstronomicalUnits()->uom());
        self::assertInstanceOf(LightYears::class, $length->toLightYears()->uom());
    }

    // ---------------------------------------------------------------
    // Typed factory methods (plural forms)
    // ---------------------------------------------------------------

    public function testAstronomicalUnitsFactory(): void
    {
        self::assertInstanceOf(AstronomicalUnits::class, Length::astronomicalUnits(1)->uom());
    }

    public function testCentimetersFactory(): void
    {
        self::assertInstanceOf(Centimeters::class, Length::centimeters(1)->uom());
    }

    public function testDecametersFactory(): void
    {
        self::assertInstanceOf(Decameters::class, Length::decameters(1)->uom());
    }

    public function testDecimetersFactory(): void
    {
        self::assertInstanceOf(Decimeters::class, Length::decimeters(1)->uom());
    }

    public function testFeetFactory(): void
    {
        self::assertInstanceOf(Feet::class, Length::feet(1)->uom());
    }

    public function testHectometersFactory(): void
    {
        self::assertInstanceOf(Hectometers::class, Length::hectometers(1)->uom());
    }

    public function testInchesFactory(): void
    {
        self::assertInstanceOf(Inches::class, Length::inches(1)->uom());
    }

    public function testKilometersFactory(): void
    {
        self::assertInstanceOf(Kilometers::class, Length::kilometers(1)->uom());
    }

    public function testLightYearsFactory(): void
    {
        self::assertInstanceOf(LightYears::class, Length::lightYears(1)->uom());
    }

    public function testMicrometersFactory(): void
    {
        self::assertInstanceOf(Micrometers::class, Length::micrometers(1)->uom());
    }

    public function testMilesFactory(): void
    {
        self::assertInstanceOf(Miles::class, Length::miles(1)->uom());
    }

    public function testMillimetersFactory(): void
    {
        self::assertInstanceOf(Millimeters::class, Length::millimeters(1)->uom());
    }

    public function testNanometersFactory(): void
    {
        self::assertInstanceOf(Nanometers::class, Length::nanometers(1)->uom());
    }

    public function testNauticalMilesFactory(): void
    {
        self::assertInstanceOf(NauticalMiles::class, Length::nauticalMiles(1)->uom());
    }

    public function testYardsFactory(): void
    {
        self::assertInstanceOf(Yards::class, Length::yards(1)->uom());
    }

    // ---------------------------------------------------------------
    // Typed factory methods (singular forms)
    // ---------------------------------------------------------------

    public function testAstronomicalUnitFactory(): void
    {
        self::assertInstanceOf(AstronomicalUnits::class, Length::astronomicalUnit(1)->uom());
    }

    public function testCentimeterFactory(): void
    {
        self::assertInstanceOf(Centimeters::class, Length::centimeter(1)->uom());
    }

    public function testDecameterFactory(): void
    {
        self::assertInstanceOf(Decameters::class, Length::decameter(1)->uom());
    }

    public function testdecimeterFactory(): void
    {
        self::assertInstanceOf(Decimeters::class, Length::decimeter(1)->uom());
    }

    public function testFootFactory(): void
    {
        self::assertInstanceOf(Feet::class, Length::foot(1)->uom());
    }

    public function testHectometerFactory(): void
    {
        self::assertInstanceOf(Hectometers::class, Length::hectometer(1)->uom());
    }

    public function testInchFactory(): void
    {
        self::assertInstanceOf(Inches::class, Length::inch(1)->uom());
    }

    public function testKilometerFactory(): void
    {
        self::assertInstanceOf(Kilometers::class, Length::kilometer(1)->uom());
    }

    public function testLightYearFactory(): void
    {
        self::assertInstanceOf(LightYears::class, Length::lightYear(1)->uom());
    }

    public function testMicrometerFactory(): void
    {
        self::assertInstanceOf(Micrometers::class, Length::micrometer(1)->uom());
    }

    public function testMileFactory(): void
    {
        self::assertInstanceOf(Miles::class, Length::mile(1)->uom());
    }

    public function testMillimeterFactory(): void
    {
        self::assertInstanceOf(Millimeters::class, Length::millimeter(1)->uom());
    }

    public function testNanometerFactory(): void
    {
        self::assertInstanceOf(Nanometers::class, Length::nanometer(1)->uom());
    }

    public function testNauticalMileFactory(): void
    {
        self::assertInstanceOf(NauticalMiles::class, Length::nauticalMile(1)->uom());
    }

    public function testYardFactory(): void
    {
        self::assertInstanceOf(Yards::class, Length::yard(1)->uom());
    }
}
