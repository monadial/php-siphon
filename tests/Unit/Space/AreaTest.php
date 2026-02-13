<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Space;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Space\Area;
use Monadial\Siphon\Unit\Space\Area\Acres;
use Monadial\Siphon\Unit\Space\Area\Barns;
use Monadial\Siphon\Unit\Space\Area\Hectares;
use Monadial\Siphon\Unit\Space\Area\SquareCentimeters;
use Monadial\Siphon\Unit\Space\Area\SquareFeet;
use Monadial\Siphon\Unit\Space\Area\SquareInches;
use Monadial\Siphon\Unit\Space\Area\SquareKilometers;
use Monadial\Siphon\Unit\Space\Area\SquareMeters;
use Monadial\Siphon\Unit\Space\Area\SquareMiles;
use Monadial\Siphon\Unit\Space\Area\SquareMillimeters;
use Monadial\Siphon\Unit\Space\Area\SquareYards;
use Monadial\Siphon\Unit\Space\AreaUnit;
use Monadial\Siphon\Unit\Space\Length;
use Monadial\Siphon\Unit\Space\Length\Meters;
use Monadial\Siphon\Unit\Space\LengthUnit;
use Monadial\Siphon\Unit\Space\Volume;
use Monadial\Siphon\Unit\Space\Volume\CubicMeters;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Area::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(SquareMillimeters::class)]
#[UsesClass(SquareCentimeters::class)]
#[UsesClass(SquareMeters::class)]
#[UsesClass(Hectares::class)]
#[UsesClass(SquareKilometers::class)]
#[UsesClass(SquareInches::class)]
#[UsesClass(SquareFeet::class)]
#[UsesClass(SquareYards::class)]
#[UsesClass(SquareMiles::class)]
#[UsesClass(Acres::class)]
#[UsesClass(Barns::class)]
#[UsesClass(AreaUnit::class)]
#[UsesClass(Volume::class)]
#[UsesClass(CubicMeters::class)]
#[UsesClass(Length::class)]
#[UsesClass(LengthUnit::class)]
#[UsesClass(Meters::class)]
final class AreaTest extends TestCase
{
    // ---------------------------------------------------------------
    // Construction and basic accessors
    // ---------------------------------------------------------------

    /**
     * @return array<string, array{string, AreaUnit, AreaUnit, string}>
     */
    public static function conversionProvider(): array
    {
        return [
            '0.5 km2 = 500000 m2' => ['0.5', SquareKilometers::make(), SquareMeters::make(), '500000'],
            '1 ha = 10000 m2' => ['1', Hectares::make(), SquareMeters::make(), '10000'],
            '1 km2 = 1000000 m2' => ['1', SquareKilometers::make(), SquareMeters::make(), '1000000'],
            '1 m2 = 10000 cm2' => ['1', SquareMeters::make(), SquareCentimeters::make(), '10000'],
            '1 m2 = 1000000 mm2' => ['1', SquareMeters::make(), SquareMillimeters::make(), '1000000'],
            '2.5 m2 identity' => ['2.5', SquareMeters::make(), SquareMeters::make(), '2.5'],
            '5 ha = 50000 m2' => ['5', Hectares::make(), SquareMeters::make(), '50000'],
        ];
    }

    public function testConstructionAndValueAccess(): void
    {
        $area = new Area(BigDecimal::of('100'), SquareMeters::make());

        self::assertTrue($area->value()->isEqualTo(BigDecimal::of('100')));
        self::assertInstanceOf(SquareMeters::class, $area->uom());
    }

    public function testCubicFactoryCreatesVolumeInCubicMeters(): void
    {
        $volume = Area::cubic(Length::meters(10), Length::meters(20), Length::meters(30));

        self::assertEqualsWithDelta(6000.0, (float) (string) $volume->value(), 0.01);
        self::assertInstanceOf(CubicMeters::class, $volume->uom());
    }

    public function testCubicFromLengths(): void
    {
        $volume = Area::cubic(Length::meters(2), Length::meters(3), Length::meters(4));

        self::assertEqualsWithDelta(24.0, (float) (string) $volume->value(), 0.01);
        self::assertInstanceOf(Volume::class, $volume);
        self::assertInstanceOf(CubicMeters::class, $volume->uom());
    }

    // ---------------------------------------------------------------
    // Identity conversions
    // ---------------------------------------------------------------

    public function testIdentityConversionSquareMeters(): void
    {
        $area = new Area(BigDecimal::of('25.5'), SquareMeters::make());
        $result = $area->toSquareMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('25.5')));
        self::assertInstanceOf(SquareMeters::class, $result->uom());
    }

    public function testIdentityConversionHectares(): void
    {
        $area = new Area(BigDecimal::of('3.7'), Hectares::make());
        $result = $area->toHectares();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('3.7')));
    }

    // ---------------------------------------------------------------
    // Square meters to other units
    // ---------------------------------------------------------------

    public function testSquareMetersToSquareCentimeters(): void
    {
        $area = new Area(BigDecimal::of('1'), SquareMeters::make());
        $result = $area->toSquareCentimeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('10000')));
        self::assertInstanceOf(SquareCentimeters::class, $result->uom());
    }

    public function testSquareMetersToSquareMillimeters(): void
    {
        $area = new Area(BigDecimal::of('1'), SquareMeters::make());
        $result = $area->toSquareMillimeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
        self::assertInstanceOf(SquareMillimeters::class, $result->uom());
    }

    public function testSquareMetersToHectares(): void
    {
        $area = new Area(BigDecimal::of('10000'), SquareMeters::make());
        $result = $area->toHectares();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(Hectares::class, $result->uom());
    }

    public function testSquareMetersToSquareKilometers(): void
    {
        $area = new Area(BigDecimal::of('1000000'), SquareMeters::make());
        $result = $area->toSquareKilometers();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(SquareKilometers::class, $result->uom());
    }

    // ---------------------------------------------------------------
    // Other units to square meters
    // ---------------------------------------------------------------

    public function testSquareKilometersToSquareMeters(): void
    {
        $area = new Area(BigDecimal::of('1'), SquareKilometers::make());
        $result = $area->toSquareMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    public function testHectaresToSquareMeters(): void
    {
        $area = new Area(BigDecimal::of('1'), Hectares::make());
        $result = $area->toSquareMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('10000')));
    }

    public function testSquareCentimetersToSquareMeters(): void
    {
        $area = new Area(BigDecimal::of('10000'), SquareCentimeters::make());
        $result = $area->toSquareMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testSquareMillimetersToSquareMeters(): void
    {
        $area = new Area(BigDecimal::of('1000000'), SquareMillimeters::make());
        $result = $area->toSquareMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    // ---------------------------------------------------------------
    // Cross-conversions
    // ---------------------------------------------------------------

    public function testSquareKilometersToSquareMillimeters(): void
    {
        $area = new Area(BigDecimal::of('1'), SquareKilometers::make());
        $result = $area->toSquareMillimeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000000000')));
    }

    public function testSquareMillimetersToSquareKilometers(): void
    {
        $area = new Area(BigDecimal::of('1000000000000'), SquareMillimeters::make());
        $result = $area->toSquareKilometers();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testHectaresToSquareKilometers(): void
    {
        $area = new Area(BigDecimal::of('100'), Hectares::make());
        $result = $area->toSquareKilometers();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testSquareKilometersToHectares(): void
    {
        $area = new Area(BigDecimal::of('1'), SquareKilometers::make());
        $result = $area->toHectares();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('100')));
    }

    public function testSquareCentimetersToSquareMillimeters(): void
    {
        $area = new Area(BigDecimal::of('1'), SquareCentimeters::make());
        $result = $area->toSquareMillimeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('100')));
    }

    public function testSquareMillimetersToSquareCentimeters(): void
    {
        $area = new Area(BigDecimal::of('100'), SquareMillimeters::make());
        $result = $area->toSquareCentimeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    // ---------------------------------------------------------------
    // Data-provider-based systematic conversion tests
    // ---------------------------------------------------------------


    #[DataProvider('conversionProvider')]
    public function testConversion(string $inputValue, AreaUnit $from, AreaUnit $to, string $expected): void
    {
        $area = new Area(BigDecimal::of($inputValue), $from);
        $result = $area->scaleTo($to);

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
    // Fractional values
    // ---------------------------------------------------------------

    public function testFractionalSquareMetersToHectares(): void
    {
        $area = new Area(BigDecimal::of('25000'), SquareMeters::make());
        $result = $area->toHectares();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('2.5')));
    }

    public function testFractionalHectaresToSquareMeters(): void
    {
        $area = new Area(BigDecimal::of('0.5'), Hectares::make());
        $result = $area->toSquareMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5000')));
    }

    // ---------------------------------------------------------------
    // Zero and edge cases
    // ---------------------------------------------------------------

    public function testZeroValueConversion(): void
    {
        $area = new Area(BigDecimal::of('0'), SquareMeters::make());
        $result = $area->toSquareKilometers();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0')));
    }

    // ---------------------------------------------------------------
    // Return type / instance checks
    // ---------------------------------------------------------------

    public function testScaleToReturnsAreaInstance(): void
    {
        $area = new Area(BigDecimal::of('1'), SquareMeters::make());
        $result = $area->toSquareKilometers();

        self::assertInstanceOf(Area::class, $result);
    }

    public function testConversionPreservesUnitOfMeasure(): void
    {
        $area = new Area(BigDecimal::of('1'), SquareMeters::make());

        self::assertInstanceOf(SquareCentimeters::class, $area->toSquareCentimeters()->uom());
        self::assertInstanceOf(SquareMillimeters::class, $area->toSquareMillimeters()->uom());
        self::assertInstanceOf(SquareKilometers::class, $area->toSquareKilometers()->uom());
        self::assertInstanceOf(Hectares::class, $area->toHectares()->uom());
    }

    // ---------------------------------------------------------------
    // Round-trip conversions
    // ---------------------------------------------------------------

    public function testRoundTripSquareMetersToSquareKilometersAndBack(): void
    {
        $original = new Area(BigDecimal::of('5000000'), SquareMeters::make());
        $converted = $original->toSquareKilometers();
        $roundTrip = $converted->toSquareMeters();

        self::assertTrue($roundTrip->value()->isEqualTo(BigDecimal::of('5000000')));
    }

    public function testRoundTripHectaresToSquareMillimetersAndBack(): void
    {
        $original = new Area(BigDecimal::of('2'), Hectares::make());
        $converted = $original->toSquareMillimeters();
        $roundTrip = $converted->toHectares();

        self::assertTrue($roundTrip->value()->isEqualTo(BigDecimal::of('2')));
    }

    // ---------------------------------------------------------------
    // Imperial / customary unit conversions
    // ---------------------------------------------------------------

    public function testSquareMetersToSquareInches(): void
    {
        $area = new Area(BigDecimal::of('1'), SquareMeters::make());
        $result = $area->toSquareInches();

        self::assertEqualsWithDelta(1550.0031, (float) (string) $result->value(), 0.01);
        self::assertInstanceOf(SquareInches::class, $result->uom());
    }

    public function testSquareInchesToSquareMeters(): void
    {
        $area = new Area(BigDecimal::of('1'), SquareInches::make());
        $result = $area->toSquareMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.00064516')));
    }

    public function testSquareMetersToSquareFeet(): void
    {
        $area = new Area(BigDecimal::of('1'), SquareMeters::make());
        $result = $area->toSquareFeet();

        self::assertEqualsWithDelta(10.7639, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(SquareFeet::class, $result->uom());
    }

    public function testSquareFeetToSquareMeters(): void
    {
        $area = new Area(BigDecimal::of('1'), SquareFeet::make());
        $result = $area->toSquareMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.09290304')));
    }

    public function testSquareMetersToSquareYards(): void
    {
        $area = new Area(BigDecimal::of('1'), SquareMeters::make());
        $result = $area->toSquareYards();

        self::assertEqualsWithDelta(1.19599, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(SquareYards::class, $result->uom());
    }

    public function testSquareYardsToSquareMeters(): void
    {
        $area = new Area(BigDecimal::of('1'), SquareYards::make());
        $result = $area->toSquareMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.83612736')));
    }

    public function testSquareFeetToSquareInches(): void
    {
        $area = new Area(BigDecimal::of('1'), SquareFeet::make());
        $result = $area->toSquareInches();

        self::assertEqualsWithDelta(144.0, (float) (string) $result->value(), 0.001);
    }

    public function testSquareYardsToSquareFeet(): void
    {
        $area = new Area(BigDecimal::of('1'), SquareYards::make());
        $result = $area->toSquareFeet();

        self::assertEqualsWithDelta(9.0, (float) (string) $result->value(), 0.001);
    }

    public function testSquareKilometersToSquareMiles(): void
    {
        $area = new Area(BigDecimal::of('1'), SquareKilometers::make());
        $result = $area->toSquareMiles();

        self::assertEqualsWithDelta(0.386102, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(SquareMiles::class, $result->uom());
    }

    public function testSquareMilesToSquareKilometers(): void
    {
        $area = new Area(BigDecimal::of('1'), SquareMiles::make());
        $result = $area->toSquareKilometers();

        self::assertEqualsWithDelta(2.58999, (float) (string) $result->value(), 0.001);
    }

    public function testSquareMetersToAcres(): void
    {
        $area = new Area(BigDecimal::of('4046.8564224'), SquareMeters::make());
        $result = $area->toAcres();

        self::assertEqualsWithDelta(1.0, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(Acres::class, $result->uom());
    }

    public function testAcresToSquareMeters(): void
    {
        $area = new Area(BigDecimal::of('1'), Acres::make());
        $result = $area->toSquareMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('4046.8564224')));
    }

    public function testAcresToSquareFeet(): void
    {
        $area = new Area(BigDecimal::of('1'), Acres::make());
        $result = $area->toSquareFeet();

        self::assertEqualsWithDelta(43560.0, (float) (string) $result->value(), 0.1);
    }

    public function testSquareMilesToAcres(): void
    {
        $area = new Area(BigDecimal::of('1'), SquareMiles::make());
        $result = $area->toAcres();

        self::assertEqualsWithDelta(640.0, (float) (string) $result->value(), 0.001);
    }

    public function testSquareMetersToBarns(): void
    {
        $area = new Area(BigDecimal::of('1'), SquareMeters::make());
        $result = $area->toBarns();

        self::assertEqualsWithDelta(1e28, (float) (string) $result->value(), 1e23);
        self::assertInstanceOf(Barns::class, $result->uom());
    }

    public function testBarnsToSquareMeters(): void
    {
        $area = new Area(BigDecimal::of('1E28'), Barns::make());
        $result = $area->toSquareMeters();

        self::assertEqualsWithDelta(1.0, (float) (string) $result->value(), 0.001);
    }

    // ---------------------------------------------------------------
    // Imperial identity conversions
    // ---------------------------------------------------------------

    public function testIdentityConversionSquareFeet(): void
    {
        $area = new Area(BigDecimal::of('2000'), SquareFeet::make());
        $result = $area->toSquareFeet();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('2000')));
        self::assertInstanceOf(SquareFeet::class, $result->uom());
    }

    // ---------------------------------------------------------------
    // Imperial round-trip conversions
    // ---------------------------------------------------------------

    public function testRoundTripSquareMetersToSquareFeetAndBack(): void
    {
        $original = new Area(BigDecimal::of('100'), SquareMeters::make());
        $converted = $original->toSquareFeet();
        $roundTrip = $converted->toSquareMeters();

        self::assertEqualsWithDelta(100.0, (float) (string) $roundTrip->value(), 0.0001);
    }

    public function testRoundTripSquareKilometersToAcresAndBack(): void
    {
        $original = new Area(BigDecimal::of('5'), SquareKilometers::make());
        $converted = $original->toAcres();
        $roundTrip = $converted->toSquareKilometers();

        self::assertEqualsWithDelta(5.0, (float) (string) $roundTrip->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // Imperial unit of measure preservation
    // ---------------------------------------------------------------

    public function testImperialConversionPreservesUnitOfMeasure(): void
    {
        $area = new Area(BigDecimal::of('1'), SquareMeters::make());

        self::assertInstanceOf(SquareInches::class, $area->toSquareInches()->uom());
        self::assertInstanceOf(SquareFeet::class, $area->toSquareFeet()->uom());
        self::assertInstanceOf(SquareYards::class, $area->toSquareYards()->uom());
        self::assertInstanceOf(SquareMiles::class, $area->toSquareMiles()->uom());
        self::assertInstanceOf(Acres::class, $area->toAcres()->uom());
        self::assertInstanceOf(Barns::class, $area->toBarns()->uom());
    }
}
