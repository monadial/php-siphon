<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Parsing;

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
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(QuantityParser::class)]
#[UsesClass(Quantity::class)]
#[UsesClass(UnitRegistry::class)]
#[UsesClass(AliasGenerator::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(Length::class)]
#[UsesClass(LengthUnit::class)]
#[UsesClass(Meters::class)]
#[UsesClass(Kilometers::class)]
#[UsesClass(Centimeters::class)]
#[UsesClass(Decameters::class)]
#[UsesClass(Decimeters::class)]
#[UsesClass(Feet::class)]
#[UsesClass(Hectometers::class)]
#[UsesClass(Inches::class)]
#[UsesClass(LightYears::class)]
#[UsesClass(Micrometers::class)]
#[UsesClass(Miles::class)]
#[UsesClass(Millimeters::class)]
#[UsesClass(Nanometers::class)]
#[UsesClass(NauticalMiles::class)]
#[UsesClass(AstronomicalUnits::class)]
#[UsesClass(Yards::class)]
#[UsesClass(Energy::class)]
#[UsesClass(EnergyUnit::class)]
#[UsesClass(Joules::class)]
#[UsesClass(KilowattHours::class)]
#[UsesClass(BritishThermalUnits::class)]
#[UsesClass(Calories::class)]
#[UsesClass(Electronvolts::class)]
#[UsesClass(Gigajoules::class)]
#[UsesClass(GigawattHours::class)]
#[UsesClass(Kilocalories::class)]
#[UsesClass(Kilojoules::class)]
#[UsesClass(Megajoules::class)]
#[UsesClass(MegawattHours::class)]
#[UsesClass(Millijoules::class)]
#[UsesClass(WattHours::class)]
final class QuantityParserTest extends TestCase
{
    /**
     * @throws ParseFailure
     * @throws UnitNotFound
     */
    public function testParseSimpleLength(): void
    {
        $length = Length::parse('100 m');

        self::assertTrue($length->value()->isEqualTo(BigDecimal::of('100')));
        self::assertInstanceOf(Meters::class, $length->uom());
    }

    /**
     * @throws ParseFailure
     * @throws UnitNotFound
     */
    public function testParseKilometers(): void
    {
        $length = Length::parse('2.5 km');

        self::assertTrue($length->value()->isEqualTo(BigDecimal::of('2.5')));
        self::assertInstanceOf(Kilometers::class, $length->uom());
    }

    /**
     * @throws ParseFailure
     * @throws UnitNotFound
     */
    public function testParseWithoutSpace(): void
    {
        $length = Length::parse('100km');

        self::assertTrue($length->value()->isEqualTo(BigDecimal::of('100')));
        self::assertInstanceOf(Kilometers::class, $length->uom());
    }

    /**
     * @throws ParseFailure
     * @throws UnitNotFound
     */
    public function testParseNegativeValue(): void
    {
        $length = Length::parse('-10 m');

        self::assertTrue($length->value()->isEqualTo(BigDecimal::of('-10')));
    }

    /**
     * @throws ParseFailure
     * @throws UnitNotFound
     */
    public function testParseScientificNotation(): void
    {
        $length = Length::parse('1.5e3 m');

        self::assertEqualsWithDelta(1500.0, (float) (string) $length->value(), 0.001);
    }

    /**
     * @throws ParseFailure
     * @throws UnitNotFound
     */
    public function testParseDecimalValue(): void
    {
        $length = Length::parse('3.14 m');

        self::assertTrue($length->value()->isEqualTo(BigDecimal::of('3.14')));
    }

    /**
     * @throws ParseFailure
     * @throws UnitNotFound
     */
    public function testParseInvalidInputThrows(): void
    {
        $this->expectException(ParseFailure::class);

        Length::parse('not a quantity');
    }

    /**
     * @throws ParseFailure
     * @throws UnitNotFound
     */
    public function testParseEmptyStringThrows(): void
    {
        $this->expectException(ParseFailure::class);

        Length::parse('');
    }

    /**
     * @throws ParseFailure
     * @throws UnitNotFound
     */
    public function testParseUnknownUnitThrows(): void
    {
        $this->expectException(ParseFailure::class);

        Length::parse('100 unknownunit');
    }

    /**
     * @throws ParseFailure
     * @throws UnitNotFound
     */
    public function testParseEnergyUnit(): void
    {
        $energy = Energy::parse('100 kWh');

        self::assertTrue($energy->value()->isEqualTo(BigDecimal::of('100')));
        self::assertInstanceOf(KilowattHours::class, $energy->uom());
    }

    /**
     * @throws ParseFailure
     * @throws UnitNotFound
     */
    public function testParseEnergyInJoules(): void
    {
        $energy = Energy::parse('500 J');

        self::assertTrue($energy->value()->isEqualTo(BigDecimal::of('500')));
        self::assertInstanceOf(Joules::class, $energy->uom());
    }

    /**
     * @throws ParseFailure
     * @throws UnitNotFound
     */
    public function testParseWithLeadingWhitespace(): void
    {
        $length = Length::parse('  100 m  ');

        self::assertTrue($length->value()->isEqualTo(BigDecimal::of('100')));
    }

    /**
     * @throws ParseFailure
     * @throws UnitNotFound
     */
    public function testParseWithPositiveSign(): void
    {
        $length = Length::parse('+10 m');

        self::assertTrue($length->value()->isEqualTo(BigDecimal::of('10')));
    }
}
