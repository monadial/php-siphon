<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Parsing;

use Monadial\Siphon\Parsing\AliasGenerator;
use Monadial\Siphon\Unit\Dimensionless\Dimensionless\Score;
use Monadial\Siphon\Unit\Mechanics\Energy\KilowattHours;
use Monadial\Siphon\Unit\Mechanics\Power\BtusPerHour;
use Monadial\Siphon\Unit\Mechanics\Pressure\MillimetersOfMercury;
use Monadial\Siphon\Unit\Motion\Velocity\KilometersPerHour;
use Monadial\Siphon\Unit\Space\Area\SquareMeters;
use Monadial\Siphon\Unit\Space\Length\Feet;
use Monadial\Siphon\Unit\Space\Length\Kilometers;
use Monadial\Siphon\Unit\Space\Length\Meters;
use Monadial\Siphon\Unit\Space\Length\Micrometers;
use Monadial\Siphon\Unit\Space\Length\Millimeters;
use Monadial\Siphon\Unit\Temperature\Temperature\Celsius;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

#[CoversClass(AliasGenerator::class)]
#[UsesClass(Meters::class)]
#[UsesClass(Kilometers::class)]
#[UsesClass(Millimeters::class)]
#[UsesClass(Micrometers::class)]
#[UsesClass(KilometersPerHour::class)]
#[UsesClass(KilowattHours::class)]
#[UsesClass(Celsius::class)]
#[UsesClass(MillimetersOfMercury::class)]
#[UsesClass(Score::class)]
#[UsesClass(SquareMeters::class)]
#[UsesClass(Feet::class)]
#[UsesClass(BtusPerHour::class)]
#[UsesClass(UnitOfMeasure::class)]
final class AliasGeneratorTest extends TestCase
{
    public function testGenerateReturnsAliasesForMeters(): void
    {
        $aliases = AliasGenerator::generate(Meters::make());

        self::assertContains('m', $aliases);
        self::assertContains('meters', $aliases);
        self::assertContains('meter', $aliases);
    }

    public function testGenerateReturnsPrefixedAliasesForKilometers(): void
    {
        $aliases = AliasGenerator::generate(Kilometers::make());

        self::assertContains('km', $aliases);
        self::assertContains('kilometers', $aliases);
        self::assertContains('kilometer', $aliases);
    }

    public function testGenerateReturnsPrefixedAliasesForMillimeters(): void
    {
        $aliases = AliasGenerator::generate(Millimeters::make());

        self::assertContains('mm', $aliases);
        self::assertContains('millimeters', $aliases);
    }

    public function testGenerateReturnsCompoundAliases(): void
    {
        $aliases = AliasGenerator::generate(KilometersPerHour::make());

        self::assertContains('km/h', $aliases);
    }

    public function testGenerateReturnsEnergyUnitAliases(): void
    {
        $aliases = AliasGenerator::generate(KilowattHours::make());

        self::assertContains('kwh', $aliases);
    }

    public function testGenerateReturnsMicroPrefix(): void
    {
        $aliases = AliasGenerator::generate(Micrometers::make());

        self::assertContains('um', $aliases);
    }

    public function testGenerateCachesResults(): void
    {
        $unit = Meters::make();
        $first = AliasGenerator::generate($unit);
        $second = AliasGenerator::generate($unit);

        self::assertSame($first, $second);
    }

    public function testGenerateReturnsNonEmptyArray(): void
    {
        $aliases = AliasGenerator::generate(Meters::make());

        self::assertNotEmpty($aliases);
    }

    public function testGenerateIncludesNormalizedSymbol(): void
    {
        $unit = Celsius::make();
        $aliases = AliasGenerator::generate($unit);

        // Aliases are normalized to lowercase
        self::assertContains(strtolower($unit->symbol()), $aliases);
    }

    public function testGenerateReturnsUniqueAliases(): void
    {
        $aliases = AliasGenerator::generate(Meters::make());

        self::assertSame(array_values(array_unique($aliases)), $aliases);
    }

    public function testGenerateFiltersOutOfWordInClassName(): void
    {
        // MillimetersOfMercury has "Of" in the class name, which gets filtered out by expandPart
        $aliases = AliasGenerator::generate(MillimetersOfMercury::make());

        self::assertNotEmpty($aliases);
        self::assertContains('millimeters of mercury', $aliases);
        // The "of" word is filtered from expansion but appears in the full name
    }

    public function testGenerateHandlesNonPrefixedWord(): void
    {
        // "Score" has no SI prefix, so trySplitPrefix returns null
        $aliases = AliasGenerator::generate(Score::make());

        self::assertNotEmpty($aliases);
        self::assertContains('score', $aliases);
    }

    public function testGenerateHandlesCompoundClassNameWithPerSlash(): void
    {
        $aliases = AliasGenerator::generate(KilometersPerHour::make());

        // Checks that "per" becomes "/" in some aliases
        self::assertContains('km/h', $aliases);
        self::assertContains('kilometers per hour', $aliases);
    }

    public function testGenerateHandlesMultiWordUnit(): void
    {
        $aliases = AliasGenerator::generate(SquareMeters::make());

        self::assertContains('square meters', $aliases);
        self::assertContains('m2', $aliases);
    }

    public function testGenerateHandlesIrregularPluralFeet(): void
    {
        // "feet" ends in non-standard plural, singularOrPlural should handle it
        $aliases = AliasGenerator::generate(Feet::make());

        self::assertNotEmpty($aliases);
        self::assertContains('ft', $aliases);
        self::assertContains('feet', $aliases);
    }

    public function testPrefixedSymbolTokenReturnsPrefixedSymbol(): void
    {
        $method = new ReflectionMethod(AliasGenerator::class, 'prefixedSymbolToken');

        // "milliohms" = "milli" (SI prefix) + "ohms" (BASE_SYMBOLS key) -> "mOhm"
        $result = $method->invoke(null, 'milliohms');

        self::assertSame('mOhm', $result);
    }

    public function testMatchPrefixedBaseReturnsNullWhenRestNotInBaseSymbols(): void
    {
        $method = new ReflectionMethod(AliasGenerator::class, 'matchPrefixedBase');

        // "millifoo" starts with "milli" but "foo" is not a BASE_SYMBOLS key
        $result = $method->invoke(null, 'millifoo', 'milli', 'm');

        self::assertNull($result);
    }

    public function testAllAliasesAreLowercase(): void
    {
        $aliases = AliasGenerator::generate(BtusPerHour::make());

        foreach ($aliases as $alias) {
            self::assertSame(
                strtolower($alias),
                $alias,
                sprintf('Alias "%s" is not lowercase', $alias),
            );
        }
    }

    public function testSingularAndPluralFormsArePresent(): void
    {
        $aliases = AliasGenerator::generate(Meters::make());

        self::assertContains('meter', $aliases);
        self::assertContains('meters', $aliases);
    }

    public function testCacheReturnMatchesFreshGeneration(): void
    {
        $unit = Meters::make();

        $first = AliasGenerator::generate($unit);
        $cached = AliasGenerator::generate($unit);
        self::assertSame($first, $cached);

        AliasGenerator::clearCache();
        $fresh = AliasGenerator::generate($unit);
        self::assertEquals($first, $fresh);
    }

    public function testMicroPrefixNormalizesToU(): void
    {
        $aliases = AliasGenerator::generate(Micrometers::make());

        self::assertContains('um', $aliases);
        self::assertNotContains(
            "\xC2\xB5m",
            $aliases,
            'Raw µ character should be normalized to u',
        );
    }

    public function testPerWordProducesBothTextAndSlashForms(): void
    {
        $aliases = AliasGenerator::generate(KilometersPerHour::make());

        self::assertContains(
            'kilometers per hour',
            $aliases,
            'Aliases must include "per" text form',
        );
        self::assertContains(
            'km/h',
            $aliases,
            'Aliases must include "/" slash form',
        );
    }

    public function testAllAliasesAreLowercaseForMultipleUnits(): void
    {
        $units = [
            KilometersPerHour::make(),
            Micrometers::make(),
            MillimetersOfMercury::make(),
            Celsius::make(),
        ];

        foreach ($units as $unit) {
            $aliases = AliasGenerator::generate($unit);
            foreach ($aliases as $alias) {
                self::assertSame(
                    strtolower($alias),
                    $alias,
                    sprintf(
                        'Alias "%s" for %s is not lowercase',
                        $alias,
                        $unit::class,
                    ),
                );
            }
        }
    }

    protected function setUp(): void
    {
        AliasGenerator::clearCache();
    }
}
