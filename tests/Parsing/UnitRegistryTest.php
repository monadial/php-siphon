<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Parsing;

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

#[CoversClass(UnitRegistry::class)]
#[UsesClass(AliasGenerator::class)]
#[UsesClass(QuantityParser::class)]
#[UsesClass(Quantity::class)]
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
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
final class UnitRegistryTest extends TestCase
{
    /**
     * @throws ParseFailure
     * @throws UnitNotFound
     */
    public function testRegistryDiscoversLengthUnits(): void
    {
        // parse() exercises UnitRegistry::forQuantity() internally
        $length = Length::parse('100 m');

        self::assertInstanceOf(Meters::class, $length->uom());
    }

    /**
     * @throws ParseFailure
     * @throws UnitNotFound
     */
    public function testRegistryDiscoversKilometers(): void
    {
        $length = Length::parse('5 km');

        self::assertInstanceOf(Kilometers::class, $length->uom());
    }

    /**
     * @throws ParseFailure
     * @throws UnitNotFound
     */
    public function testRegistryDiscoversEnergyUnits(): void
    {
        $energy = Energy::parse('100 kWh');

        self::assertInstanceOf(KilowattHours::class, $energy->uom());
    }

    /**
     * @throws ParseFailure
     * @throws UnitNotFound
     */
    public function testRegistryCachesDiscoveredUnits(): void
    {
        // First parse triggers discovery
        Length::parse('100 m');
        // Second parse should use cached registry
        $length = Length::parse('200 km');

        self::assertInstanceOf(Kilometers::class, $length->uom());
    }

    /**
     * @throws ParseFailure
     * @throws UnitNotFound
     */
    public function testClearResetsCache(): void
    {
        Length::parse('100 m');
        UnitRegistry::clear();

        // After clearing, a fresh discovery should still work
        $length = Length::parse('50 m');
        self::assertInstanceOf(Meters::class, $length->uom());
    }

    public function testNormalizeTokenTrimsWhitespace(): void
    {
        self::assertSame('km', UnitRegistry::normalizeToken('  km  '));
    }

    public function testNormalizeTokenLowercases(): void
    {
        self::assertSame('km', UnitRegistry::normalizeToken('KM'));
    }

    public function testNormalizeTokenNormalizesSlashes(): void
    {
        self::assertSame('km/h', UnitRegistry::normalizeToken('km / h'));
    }

    public function testNormalizeTokenCollapsesSpaces(): void
    {
        self::assertSame('mega joules', UnitRegistry::normalizeToken('mega   joules'));
    }

    /** @throws UnitNotFound */
    public function testForQuantityReturnsAliasMapForLength(): void
    {
        $map = UnitRegistry::forQuantity(Length::class); // @phpstan-ignore argument.type

        self::assertArrayHasKey('m', $map);
        self::assertArrayHasKey('km', $map);
        self::assertSame(Meters::class, $map['m']);
        self::assertSame(Kilometers::class, $map['km']);
    }

    /** @throws UnitNotFound */
    public function testForQuantityReturnsAliasMapForEnergy(): void
    {
        $map = UnitRegistry::forQuantity(Energy::class); // @phpstan-ignore argument.type

        self::assertArrayHasKey('j', $map);
        self::assertSame(Joules::class, $map['j']);
    }

    /** @throws UnitNotFound */
    public function testForQuantityCachesResults(): void
    {
        $first = UnitRegistry::forQuantity(Length::class); // @phpstan-ignore argument.type
        $second = UnitRegistry::forQuantity(Length::class); // @phpstan-ignore argument.type

        self::assertSame($first, $second);
    }

    /** @throws UnitNotFound */
    public function testClearResetsCacheForDirectCalls(): void
    {
        $before = UnitRegistry::forQuantity(Length::class); // @phpstan-ignore argument.type
        UnitRegistry::clear();
        $after = UnitRegistry::forQuantity(Length::class); // @phpstan-ignore argument.type

        // Both should have the same keys even after cache clear
        self::assertSame(array_keys($before), array_keys($after));
    }

    /** @throws UnitNotFound */
    public function testForQuantityThrowsForNonSiphonNamespace(): void
    {
        $this->expectException(UnitNotFound::class);
        $this->expectExceptionMessage('Unable to infer class path');

        UnitRegistry::forQuantity(\stdClass::class); // @phpstan-ignore argument.type
    }

    /** @throws UnitNotFound */
    public function testForQuantityThrowsWhenNoUnitDirectoryFound(): void
    {
        $this->expectException(UnitNotFound::class);
        $this->expectExceptionMessage('No unit directory found');

        // Quantity itself is in Monadial\Siphon but has no unit subdirectory
        UnitRegistry::forQuantity(Quantity::class);
    }

    protected function setUp(): void
    {
        UnitRegistry::clear();
    }
}
