<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Space;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Space\Volume;
use Monadial\Siphon\Unit\Space\Volume\Centilitres;
use Monadial\Siphon\Unit\Space\Volume\CubicCentimeters;
use Monadial\Siphon\Unit\Space\Volume\CubicFeet;
use Monadial\Siphon\Unit\Space\Volume\CubicInches;
use Monadial\Siphon\Unit\Space\Volume\CubicMeters;
use Monadial\Siphon\Unit\Space\Volume\CubicYards;
use Monadial\Siphon\Unit\Space\Volume\Decilitres;
use Monadial\Siphon\Unit\Space\Volume\FluidOunces;
use Monadial\Siphon\Unit\Space\Volume\Hectolitres;
use Monadial\Siphon\Unit\Space\Volume\ImperialGallons;
use Monadial\Siphon\Unit\Space\Volume\Litres;
use Monadial\Siphon\Unit\Space\Volume\Millilitres;
use Monadial\Siphon\Unit\Space\Volume\Tablespoons;
use Monadial\Siphon\Unit\Space\Volume\Teaspoons;
use Monadial\Siphon\Unit\Space\Volume\UsCups;
use Monadial\Siphon\Unit\Space\Volume\UsGallons;
use Monadial\Siphon\Unit\Space\Volume\UsPints;
use Monadial\Siphon\Unit\Space\Volume\UsQuarts;
use Monadial\Siphon\Unit\Space\VolumeUnit;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Volume::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(CubicCentimeters::class)]
#[UsesClass(Millilitres::class)]
#[UsesClass(Centilitres::class)]
#[UsesClass(Decilitres::class)]
#[UsesClass(Litres::class)]
#[UsesClass(Hectolitres::class)]
#[UsesClass(CubicMeters::class)]
#[UsesClass(CubicInches::class)]
#[UsesClass(CubicFeet::class)]
#[UsesClass(CubicYards::class)]
#[UsesClass(UsGallons::class)]
#[UsesClass(UsPints::class)]
#[UsesClass(UsQuarts::class)]
#[UsesClass(UsCups::class)]
#[UsesClass(FluidOunces::class)]
#[UsesClass(Tablespoons::class)]
#[UsesClass(Teaspoons::class)]
#[UsesClass(ImperialGallons::class)]
#[UsesClass(VolumeUnit::class)]
final class VolumeTest extends TestCase
{
    // ---------------------------------------------------------------
    // Construction and basic accessors
    // ---------------------------------------------------------------

    /**
     * @return array<string, array{string, VolumeUnit, VolumeUnit, string}>
     */
    public static function conversionProvider(): array
    {
        return [
            '1 cL = 10 mL' => ['1', Centilitres::make(), Millilitres::make(), '10'],
            '1 dL = 100 mL' => ['1', Decilitres::make(), Millilitres::make(), '100'],
            '1 hL = 100 L' => ['1', Hectolitres::make(), Litres::make(), '100'],
            '1 L = 1000 mL' => ['1', Litres::make(), Millilitres::make(), '1000'],
            '1 m3 = 10 hL' => ['1', CubicMeters::make(), Hectolitres::make(), '10'],
            '1 m3 = 1000 L' => ['1', CubicMeters::make(), Litres::make(), '1000'],
            '1 m3 = 1000000 cm3' => ['1', CubicMeters::make(), CubicCentimeters::make(), '1000000'],
            '1 m3 = 1000000 mL' => ['1', CubicMeters::make(), Millilitres::make(), '1000000'],
            '1 mL = 1 cm3' => ['1', Millilitres::make(), CubicCentimeters::make(), '1'],
            '2.5 L identity' => ['2.5', Litres::make(), Litres::make(), '2.5'],
            '330 mL = 33 cL' => ['330', Millilitres::make(), Centilitres::make(), '33'],
            '500 mL = 0.5 L' => ['500', Millilitres::make(), Litres::make(), '0.5'],
            '750 mL = 75 cL' => ['750', Millilitres::make(), Centilitres::make(), '75'],
        ];
    }

    public function testConstructionAndValueAccess(): void
    {
        $volume = new Volume(BigDecimal::of('500'), Litres::make());

        self::assertTrue($volume->value()->isEqualTo(BigDecimal::of('500')));
        self::assertInstanceOf(Litres::class, $volume->uom());
    }

    // ---------------------------------------------------------------
    // Identity conversions
    // ---------------------------------------------------------------

    public function testIdentityConversionLitres(): void
    {
        $volume = new Volume(BigDecimal::of('7.5'), Litres::make());
        $result = $volume->toLitres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('7.5')));
        self::assertInstanceOf(Litres::class, $result->uom());
    }

    public function testIdentityConversionCubicMeters(): void
    {
        $volume = new Volume(BigDecimal::of('3.14'), CubicMeters::make());
        $result = $volume->toCubicMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('3.14')));
    }

    // ---------------------------------------------------------------
    // Cubic meters to other units
    // ---------------------------------------------------------------

    public function testCubicMetersToLitres(): void
    {
        $volume = new Volume(BigDecimal::of('1'), CubicMeters::make());
        $result = $volume->toLitres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
        self::assertInstanceOf(Litres::class, $result->uom());
    }

    public function testCubicMetersToMillilitres(): void
    {
        $volume = new Volume(BigDecimal::of('1'), CubicMeters::make());
        $result = $volume->toMillilitres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
        self::assertInstanceOf(Millilitres::class, $result->uom());
    }

    public function testCubicMetersToHectolitres(): void
    {
        $volume = new Volume(BigDecimal::of('1'), CubicMeters::make());
        $result = $volume->toHectolitres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('10')));
        self::assertInstanceOf(Hectolitres::class, $result->uom());
    }

    public function testCubicMetersToCentilitres(): void
    {
        $volume = new Volume(BigDecimal::of('1'), CubicMeters::make());
        $result = $volume->toCentilitres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('100000')));
        self::assertInstanceOf(Centilitres::class, $result->uom());
    }

    public function testCubicMetersToDecilitres(): void
    {
        $volume = new Volume(BigDecimal::of('1'), CubicMeters::make());
        $result = $volume->toDecilitres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('10000')));
        self::assertInstanceOf(Decilitres::class, $result->uom());
    }

    public function testCubicMetersToCubicCentimeters(): void
    {
        $volume = new Volume(BigDecimal::of('1'), CubicMeters::make());
        $result = $volume->toCubicCentimeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
        self::assertInstanceOf(CubicCentimeters::class, $result->uom());
    }

    // ---------------------------------------------------------------
    // Litre-based conversions
    // ---------------------------------------------------------------

    public function testLitresToMillilitres(): void
    {
        $volume = new Volume(BigDecimal::of('1'), Litres::make());
        $result = $volume->toMillilitres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testMillilitresToLitres(): void
    {
        $volume = new Volume(BigDecimal::of('1000'), Millilitres::make());
        $result = $volume->toLitres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testLitresToCentilitres(): void
    {
        $volume = new Volume(BigDecimal::of('1'), Litres::make());
        $result = $volume->toCentilitres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('100')));
    }

    public function testCentilitresToLitres(): void
    {
        $volume = new Volume(BigDecimal::of('100'), Centilitres::make());
        $result = $volume->toLitres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testLitresToDecilitres(): void
    {
        $volume = new Volume(BigDecimal::of('1'), Litres::make());
        $result = $volume->toDecilitres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('10')));
    }

    public function testDecilitresToLitres(): void
    {
        $volume = new Volume(BigDecimal::of('10'), Decilitres::make());
        $result = $volume->toLitres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testHectolitresToLitres(): void
    {
        $volume = new Volume(BigDecimal::of('1'), Hectolitres::make());
        $result = $volume->toLitres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('100')));
    }

    public function testLitresToHectolitres(): void
    {
        $volume = new Volume(BigDecimal::of('100'), Litres::make());
        $result = $volume->toHectolitres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testLitresToCubicMeters(): void
    {
        $volume = new Volume(BigDecimal::of('1000'), Litres::make());
        $result = $volume->toCubicMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    // ---------------------------------------------------------------
    // Millilitres and cubic centimeters equivalence
    // ---------------------------------------------------------------

    public function testMillilitresToCubicCentimeters(): void
    {
        $volume = new Volume(BigDecimal::of('1'), Millilitres::make());
        $result = $volume->toCubicCentimeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testCubicCentimetersToMillilitres(): void
    {
        $volume = new Volume(BigDecimal::of('1'), CubicCentimeters::make());
        $result = $volume->toMillilitres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testCubicCentimetersToLitres(): void
    {
        $volume = new Volume(BigDecimal::of('1000'), CubicCentimeters::make());
        $result = $volume->toLitres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    // ---------------------------------------------------------------
    // Cross-unit conversions
    // ---------------------------------------------------------------

    public function testCentilitresToMillilitres(): void
    {
        $volume = new Volume(BigDecimal::of('1'), Centilitres::make());
        $result = $volume->toMillilitres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('10')));
    }

    public function testDecilitresToMillilitres(): void
    {
        $volume = new Volume(BigDecimal::of('1'), Decilitres::make());
        $result = $volume->toMillilitres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('100')));
    }

    public function testHectolitresToMillilitres(): void
    {
        $volume = new Volume(BigDecimal::of('1'), Hectolitres::make());
        $result = $volume->toMillilitres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('100000')));
    }

    public function testDecilitresToCentilitres(): void
    {
        $volume = new Volume(BigDecimal::of('1'), Decilitres::make());
        $result = $volume->toCentilitres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('10')));
    }

    public function testHectolitresToDecilitres(): void
    {
        $volume = new Volume(BigDecimal::of('1'), Hectolitres::make());
        $result = $volume->toDecilitres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    // ---------------------------------------------------------------
    // Data-provider-based systematic conversion tests
    // ---------------------------------------------------------------


    #[DataProvider('conversionProvider')]
    public function testConversion(string $inputValue, VolumeUnit $from, VolumeUnit $to, string $expected): void
    {
        $volume = new Volume(BigDecimal::of($inputValue), $from);
        $result = $volume->scaleTo($to);

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

    public function testFractionalLitresToMillilitres(): void
    {
        $volume = new Volume(BigDecimal::of('0.5'), Litres::make());
        $result = $volume->toMillilitres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('500')));
    }

    public function testFractionalCubicMetersToLitres(): void
    {
        $volume = new Volume(BigDecimal::of('0.001'), CubicMeters::make());
        $result = $volume->toLitres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    // ---------------------------------------------------------------
    // Zero and edge cases
    // ---------------------------------------------------------------

    public function testZeroValueConversion(): void
    {
        $volume = new Volume(BigDecimal::of('0'), Litres::make());
        $result = $volume->toMillilitres();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0')));
    }

    // ---------------------------------------------------------------
    // Return type / instance checks
    // ---------------------------------------------------------------

    public function testScaleToReturnsVolumeInstance(): void
    {
        $volume = new Volume(BigDecimal::of('1'), Litres::make());
        $result = $volume->toMillilitres();

        self::assertInstanceOf(Volume::class, $result);
    }

    public function testConversionPreservesUnitOfMeasure(): void
    {
        $volume = new Volume(BigDecimal::of('1'), CubicMeters::make());

        self::assertInstanceOf(Litres::class, $volume->toLitres()->uom());
        self::assertInstanceOf(Millilitres::class, $volume->toMillilitres()->uom());
        self::assertInstanceOf(Centilitres::class, $volume->toCentilitres()->uom());
        self::assertInstanceOf(Decilitres::class, $volume->toDecilitres()->uom());
        self::assertInstanceOf(Hectolitres::class, $volume->toHectolitres()->uom());
        self::assertInstanceOf(CubicCentimeters::class, $volume->toCubicCentimeters()->uom());
    }

    // ---------------------------------------------------------------
    // Round-trip conversions
    // ---------------------------------------------------------------

    public function testRoundTripLitresToCubicMetersAndBack(): void
    {
        $original = new Volume(BigDecimal::of('500'), Litres::make());
        $converted = $original->toCubicMeters();
        $roundTrip = $converted->toLitres();

        self::assertTrue($roundTrip->value()->isEqualTo(BigDecimal::of('500')));
    }

    public function testRoundTripMillilitresToHectolitresAndBack(): void
    {
        $original = new Volume(BigDecimal::of('100000'), Millilitres::make());
        $converted = $original->toHectolitres();
        $roundTrip = $converted->toMillilitres();

        self::assertTrue($roundTrip->value()->isEqualTo(BigDecimal::of('100000')));
    }

    public function testRoundTripCentilitresToCubicCentimetersAndBack(): void
    {
        $original = new Volume(BigDecimal::of('50'), Centilitres::make());
        $converted = $original->toCubicCentimeters();
        $roundTrip = $converted->toCentilitres();

        self::assertTrue($roundTrip->value()->isEqualTo(BigDecimal::of('50')));
    }

    // ---------------------------------------------------------------
    // Imperial / customary unit conversions
    // ---------------------------------------------------------------

    public function testLitresToCubicInches(): void
    {
        $volume = new Volume(BigDecimal::of('1'), Litres::make());
        $result = $volume->toCubicInches();

        self::assertEqualsWithDelta(61.0237, (float) (string) $result->value(), 0.01);
        self::assertInstanceOf(CubicInches::class, $result->uom());
    }

    public function testCubicInchesToLitres(): void
    {
        $volume = new Volume(BigDecimal::of('61.0237'), CubicInches::make());
        $result = $volume->toLitres();

        self::assertEqualsWithDelta(1.0, (float) (string) $result->value(), 0.001);
    }

    public function testCubicMetersToCubicFeet(): void
    {
        $volume = new Volume(BigDecimal::of('1'), CubicMeters::make());
        $result = $volume->toCubicFeet();

        self::assertEqualsWithDelta(35.3147, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(CubicFeet::class, $result->uom());
    }

    public function testCubicFeetToCubicMeters(): void
    {
        $volume = new Volume(BigDecimal::of('1'), CubicFeet::make());
        $result = $volume->toCubicMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.028316846592')));
    }

    public function testCubicFeetToCubicInches(): void
    {
        $volume = new Volume(BigDecimal::of('1'), CubicFeet::make());
        $result = $volume->toCubicInches();

        self::assertEqualsWithDelta(1728.0, (float) (string) $result->value(), 0.01);
    }

    public function testCubicMetersToCubicYards(): void
    {
        $volume = new Volume(BigDecimal::of('1'), CubicMeters::make());
        $result = $volume->toCubicYards();

        self::assertEqualsWithDelta(1.30795, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(CubicYards::class, $result->uom());
    }

    public function testCubicYardsToCubicFeet(): void
    {
        $volume = new Volume(BigDecimal::of('1'), CubicYards::make());
        $result = $volume->toCubicFeet();

        self::assertEqualsWithDelta(27.0, (float) (string) $result->value(), 0.001);
    }

    public function testLitresToUsGallons(): void
    {
        $volume = new Volume(BigDecimal::of('1'), Litres::make());
        $result = $volume->toUsGallons();

        self::assertEqualsWithDelta(0.264172, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(UsGallons::class, $result->uom());
    }

    public function testUsGallonsToLitres(): void
    {
        $volume = new Volume(BigDecimal::of('1'), UsGallons::make());
        $result = $volume->toLitres();

        self::assertEqualsWithDelta(3.78541, (float) (string) $result->value(), 0.001);
    }

    public function testUsGallonsToUsPints(): void
    {
        $volume = new Volume(BigDecimal::of('1'), UsGallons::make());
        $result = $volume->toUsPints();

        self::assertEqualsWithDelta(8.0, (float) (string) $result->value(), 0.001);
    }

    public function testUsGallonsToUsQuarts(): void
    {
        $volume = new Volume(BigDecimal::of('1'), UsGallons::make());
        $result = $volume->toUsQuarts();

        self::assertEqualsWithDelta(4.0, (float) (string) $result->value(), 0.001);
    }

    public function testUsGallonsToUsCups(): void
    {
        $volume = new Volume(BigDecimal::of('1'), UsGallons::make());
        $result = $volume->toUsCups();

        self::assertEqualsWithDelta(16.0, (float) (string) $result->value(), 0.001);
    }

    public function testUsGallonsToFluidOunces(): void
    {
        $volume = new Volume(BigDecimal::of('1'), UsGallons::make());
        $result = $volume->toFluidOunces();

        self::assertEqualsWithDelta(128.0, (float) (string) $result->value(), 0.001);
    }

    public function testLitresToUsPints(): void
    {
        $volume = new Volume(BigDecimal::of('1'), Litres::make());
        $result = $volume->toUsPints();

        self::assertEqualsWithDelta(2.11338, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(UsPints::class, $result->uom());
    }

    public function testLitresToUsQuarts(): void
    {
        $volume = new Volume(BigDecimal::of('1'), Litres::make());
        $result = $volume->toUsQuarts();

        self::assertEqualsWithDelta(1.05669, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(UsQuarts::class, $result->uom());
    }

    public function testLitresToUsCups(): void
    {
        $volume = new Volume(BigDecimal::of('1'), Litres::make());
        $result = $volume->toUsCups();

        self::assertEqualsWithDelta(4.22675, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(UsCups::class, $result->uom());
    }

    public function testLitresToFluidOunces(): void
    {
        $volume = new Volume(BigDecimal::of('1'), Litres::make());
        $result = $volume->toFluidOunces();

        self::assertEqualsWithDelta(33.814, (float) (string) $result->value(), 0.01);
        self::assertInstanceOf(FluidOunces::class, $result->uom());
    }

    public function testTablespoonToTeaspoons(): void
    {
        $volume = new Volume(BigDecimal::of('1'), Tablespoons::make());
        $result = $volume->toTeaspoons();

        self::assertEqualsWithDelta(3.0, (float) (string) $result->value(), 0.001);
    }

    public function testFluidOuncesToTablespoons(): void
    {
        $volume = new Volume(BigDecimal::of('1'), FluidOunces::make());
        $result = $volume->toTablespoons();

        self::assertEqualsWithDelta(2.0, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(Tablespoons::class, $result->uom());
    }

    public function testLitresToTablespoons(): void
    {
        $volume = new Volume(BigDecimal::of('1'), Litres::make());
        $result = $volume->toTablespoons();

        self::assertEqualsWithDelta(67.628, (float) (string) $result->value(), 0.01);
    }

    public function testLitresToTeaspoons(): void
    {
        $volume = new Volume(BigDecimal::of('1'), Litres::make());
        $result = $volume->toTeaspoons();

        self::assertEqualsWithDelta(202.884, (float) (string) $result->value(), 0.01);
        self::assertInstanceOf(Teaspoons::class, $result->uom());
    }

    public function testLitresToImperialGallons(): void
    {
        $volume = new Volume(BigDecimal::of('1'), Litres::make());
        $result = $volume->toImperialGallons();

        self::assertEqualsWithDelta(0.219969, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(ImperialGallons::class, $result->uom());
    }

    public function testImperialGallonsToLitres(): void
    {
        $volume = new Volume(BigDecimal::of('1'), ImperialGallons::make());
        $result = $volume->toLitres();

        self::assertEqualsWithDelta(4.54609, (float) (string) $result->value(), 0.001);
    }

    public function testImperialGallonsToUsGallons(): void
    {
        $volume = new Volume(BigDecimal::of('1'), ImperialGallons::make());
        $result = $volume->toUsGallons();

        self::assertEqualsWithDelta(1.20095, (float) (string) $result->value(), 0.001);
    }

    // ---------------------------------------------------------------
    // Imperial identity conversions
    // ---------------------------------------------------------------

    public function testIdentityConversionUsGallons(): void
    {
        $volume = new Volume(BigDecimal::of('5'), UsGallons::make());
        $result = $volume->toUsGallons();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5')));
        self::assertInstanceOf(UsGallons::class, $result->uom());
    }

    // ---------------------------------------------------------------
    // Imperial round-trip conversions
    // ---------------------------------------------------------------

    public function testRoundTripLitresToUsGallonsAndBack(): void
    {
        $original = new Volume(BigDecimal::of('10'), Litres::make());
        $converted = $original->toUsGallons();
        $roundTrip = $converted->toLitres();

        self::assertEqualsWithDelta(10.0, (float) (string) $roundTrip->value(), 0.0001);
    }

    public function testRoundTripCubicMetersToCubicFeetAndBack(): void
    {
        $original = new Volume(BigDecimal::of('5'), CubicMeters::make());
        $converted = $original->toCubicFeet();
        $roundTrip = $converted->toCubicMeters();

        self::assertEqualsWithDelta(5.0, (float) (string) $roundTrip->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // Imperial unit of measure preservation
    // ---------------------------------------------------------------

    public function testImperialConversionPreservesUnitOfMeasure(): void
    {
        $volume = new Volume(BigDecimal::of('1'), CubicMeters::make());

        self::assertInstanceOf(CubicInches::class, $volume->toCubicInches()->uom());
        self::assertInstanceOf(CubicFeet::class, $volume->toCubicFeet()->uom());
        self::assertInstanceOf(CubicYards::class, $volume->toCubicYards()->uom());
        self::assertInstanceOf(UsGallons::class, $volume->toUsGallons()->uom());
        self::assertInstanceOf(UsPints::class, $volume->toUsPints()->uom());
        self::assertInstanceOf(UsQuarts::class, $volume->toUsQuarts()->uom());
        self::assertInstanceOf(UsCups::class, $volume->toUsCups()->uom());
        self::assertInstanceOf(FluidOunces::class, $volume->toFluidOunces()->uom());
        self::assertInstanceOf(Tablespoons::class, $volume->toTablespoons()->uom());
        self::assertInstanceOf(Teaspoons::class, $volume->toTeaspoons()->uom());
        self::assertInstanceOf(ImperialGallons::class, $volume->toImperialGallons()->uom());
    }

    // ---------------------------------------------------------------
    // Typed factory methods (plural forms)
    // ---------------------------------------------------------------

    public function testCentilitresFactory(): void
    {
        self::assertInstanceOf(Centilitres::class, Volume::centilitres(1)->uom());
    }

    public function testCubicCentimetersFactory(): void
    {
        self::assertInstanceOf(CubicCentimeters::class, Volume::cubicCentimeters(1)->uom());
    }

    public function testCubicFeetFactory(): void
    {
        self::assertInstanceOf(CubicFeet::class, Volume::cubicFeet(1)->uom());
    }

    public function testCubicInchesFactory(): void
    {
        self::assertInstanceOf(CubicInches::class, Volume::cubicInches(1)->uom());
    }

    public function testCubicMetersFactory(): void
    {
        self::assertInstanceOf(CubicMeters::class, Volume::cubicMeters(1)->uom());
    }

    public function testCubicYardsFactory(): void
    {
        self::assertInstanceOf(CubicYards::class, Volume::cubicYards(1)->uom());
    }

    public function testDecilitresFactory(): void
    {
        self::assertInstanceOf(Decilitres::class, Volume::decilitres(1)->uom());
    }

    public function testFluidOuncesFactory(): void
    {
        self::assertInstanceOf(FluidOunces::class, Volume::fluidOunces(1)->uom());
    }

    public function testHectolitresFactory(): void
    {
        self::assertInstanceOf(Hectolitres::class, Volume::hectolitres(1)->uom());
    }

    public function testImperialGallonsFactory(): void
    {
        self::assertInstanceOf(ImperialGallons::class, Volume::imperialGallons(1)->uom());
    }

    public function testLitresFactory(): void
    {
        self::assertInstanceOf(Litres::class, Volume::litres(1)->uom());
    }

    public function testMillilitresFactory(): void
    {
        self::assertInstanceOf(Millilitres::class, Volume::millilitres(1)->uom());
    }

    public function testTablespoonsFactory(): void
    {
        self::assertInstanceOf(Tablespoons::class, Volume::tablespoons(1)->uom());
    }

    public function testTeaspoonsFactory(): void
    {
        self::assertInstanceOf(Teaspoons::class, Volume::teaspoons(1)->uom());
    }

    public function testUsCupsFactory(): void
    {
        self::assertInstanceOf(UsCups::class, Volume::usCups(1)->uom());
    }

    public function testUsGallonsFactory(): void
    {
        self::assertInstanceOf(UsGallons::class, Volume::usGallons(1)->uom());
    }

    public function testUsPintsFactory(): void
    {
        self::assertInstanceOf(UsPints::class, Volume::usPints(1)->uom());
    }

    public function testUsQuartsFactory(): void
    {
        self::assertInstanceOf(UsQuarts::class, Volume::usQuarts(1)->uom());
    }

    // ---------------------------------------------------------------
    // Typed factory methods (singular forms)
    // ---------------------------------------------------------------

    public function testCentilitreFactory(): void
    {
        self::assertInstanceOf(Centilitres::class, Volume::centilitre(1)->uom());
    }

    public function testCubicCentimeterFactory(): void
    {
        self::assertInstanceOf(CubicCentimeters::class, Volume::cubicCentimeter(1)->uom());
    }

    public function testCubicInchFactory(): void
    {
        self::assertInstanceOf(CubicInches::class, Volume::cubicInch(1)->uom());
    }

    public function testCubicMeterFactory(): void
    {
        self::assertInstanceOf(CubicMeters::class, Volume::cubicMeter(1)->uom());
    }

    public function testCubicYardFactory(): void
    {
        self::assertInstanceOf(CubicYards::class, Volume::cubicYard(1)->uom());
    }

    public function testDecilitreFactory(): void
    {
        self::assertInstanceOf(Decilitres::class, Volume::decilitre(1)->uom());
    }

    public function testFluidOunceFactory(): void
    {
        self::assertInstanceOf(FluidOunces::class, Volume::fluidOunce(1)->uom());
    }

    public function testHectolitreFactory(): void
    {
        self::assertInstanceOf(Hectolitres::class, Volume::hectolitre(1)->uom());
    }

    public function testImperialGallonFactory(): void
    {
        self::assertInstanceOf(ImperialGallons::class, Volume::imperialGallon(1)->uom());
    }

    public function testLitreFactory(): void
    {
        self::assertInstanceOf(Litres::class, Volume::litre(1)->uom());
    }

    public function testMillilitreFactory(): void
    {
        self::assertInstanceOf(Millilitres::class, Volume::millilitre(1)->uom());
    }

    public function testTablespoonFactory(): void
    {
        self::assertInstanceOf(Tablespoons::class, Volume::tablespoon(1)->uom());
    }

    public function testTeaspoonFactory(): void
    {
        self::assertInstanceOf(Teaspoons::class, Volume::teaspoon(1)->uom());
    }

    public function testUsCupFactory(): void
    {
        self::assertInstanceOf(UsCups::class, Volume::usCup(1)->uom());
    }

    public function testUsGallonFactory(): void
    {
        self::assertInstanceOf(UsGallons::class, Volume::usGallon(1)->uom());
    }

    public function testUsPintFactory(): void
    {
        self::assertInstanceOf(UsPints::class, Volume::usPint(1)->uom());
    }

    public function testUsQuartFactory(): void
    {
        self::assertInstanceOf(UsQuarts::class, Volume::usQuart(1)->uom());
    }
}
