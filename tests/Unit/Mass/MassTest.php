<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Mass;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mass\Mass;
use Monadial\Siphon\Unit\Mass\Mass\Grams;
use Monadial\Siphon\Unit\Mass\Mass\Kilograms;
use Monadial\Siphon\Unit\Mass\Mass\Micrograms;
use Monadial\Siphon\Unit\Mass\Mass\Milligrams;
use Monadial\Siphon\Unit\Mass\Mass\Ounces;
use Monadial\Siphon\Unit\Mass\Mass\Pounds;
use Monadial\Siphon\Unit\Mass\Mass\Stones;
use Monadial\Siphon\Unit\Mass\Mass\Tonnes;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Mass::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(Micrograms::class)]
#[UsesClass(Milligrams::class)]
#[UsesClass(Grams::class)]
#[UsesClass(Kilograms::class)]
#[UsesClass(Tonnes::class)]
#[UsesClass(Pounds::class)]
#[UsesClass(Ounces::class)]
#[UsesClass(Stones::class)]
final class MassTest extends TestCase
{
    public function testIdentityConversion(): void
    {
        $mass = new Mass(BigDecimal::of('75.5'), Kilograms::make());
        $result = $mass->toKilograms();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('75.5')));
    }

    public function testKilogramsToGrams(): void
    {
        $mass = new Mass(BigDecimal::of('2.5'), Kilograms::make());
        $result = $mass->toGrams();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('2500')));
    }

    public function testGramsToKilograms(): void
    {
        $mass = new Mass(BigDecimal::of('500'), Grams::make());
        $result = $mass->toKilograms();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.5')));
    }

    public function testKilogramsToMilligrams(): void
    {
        $mass = new Mass(BigDecimal::of('1'), Kilograms::make());
        $result = $mass->toMilligrams();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    public function testMilligramsToGrams(): void
    {
        $mass = new Mass(BigDecimal::of('1500'), Milligrams::make());
        $result = $mass->toGrams();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1.5')));
    }

    public function testKilogramsToTonnes(): void
    {
        $mass = new Mass(BigDecimal::of('2500'), Kilograms::make());
        $result = $mass->toTonnes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('2.5')));
    }

    public function testTonnesToKilograms(): void
    {
        $mass = new Mass(BigDecimal::of('3.5'), Tonnes::make());
        $result = $mass->toKilograms();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('3500')));
    }

    public function testKilogramsToMicrograms(): void
    {
        $mass = new Mass(BigDecimal::of('0.001'), Kilograms::make());
        $result = $mass->toMicrograms();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    public function testMicrogramsToKilograms(): void
    {
        $mass = new Mass(BigDecimal::of('1000000000'), Micrograms::make());
        $result = $mass->toKilograms();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testTonnesToMilligrams(): void
    {
        $mass = new Mass(BigDecimal::of('1'), Tonnes::make());
        $result = $mass->toMilligrams();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000000')));
    }

    // ---------------------------------------------------------------
    // Imperial / customary unit conversions
    // ---------------------------------------------------------------

    public function testKilogramsToPounds(): void
    {
        $mass = new Mass(BigDecimal::of('1'), Kilograms::make());
        $result = $mass->toPounds();

        self::assertEqualsWithDelta(2.20462, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(Pounds::class, $result->uom());
    }

    public function testPoundsToKilograms(): void
    {
        $mass = new Mass(BigDecimal::of('1'), Pounds::make());
        $result = $mass->toKilograms();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.45359237')));
    }

    public function testKilogramsToOunces(): void
    {
        $mass = new Mass(BigDecimal::of('1'), Kilograms::make());
        $result = $mass->toOunces();

        self::assertEqualsWithDelta(35.274, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(Ounces::class, $result->uom());
    }

    public function testOuncesToKilograms(): void
    {
        $mass = new Mass(BigDecimal::of('1'), Ounces::make());
        $result = $mass->toKilograms();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.028349523125')));
    }

    public function testPoundsToOunces(): void
    {
        $mass = new Mass(BigDecimal::of('1'), Pounds::make());
        $result = $mass->toOunces();

        self::assertEqualsWithDelta(16.0, (float) (string) $result->value(), 0.001);
    }

    public function testKilogramsToStones(): void
    {
        $mass = new Mass(BigDecimal::of('1'), Kilograms::make());
        $result = $mass->toStones();

        self::assertEqualsWithDelta(0.157473, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(Stones::class, $result->uom());
    }

    public function testStonesToKilograms(): void
    {
        $mass = new Mass(BigDecimal::of('1'), Stones::make());
        $result = $mass->toKilograms();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('6.35029318')));
    }

    public function testStonesToPounds(): void
    {
        $mass = new Mass(BigDecimal::of('1'), Stones::make());
        $result = $mass->toPounds();

        self::assertEqualsWithDelta(14.0, (float) (string) $result->value(), 0.001);
    }

    // ---------------------------------------------------------------
    // Imperial identity conversions
    // ---------------------------------------------------------------

    public function testIdentityConversionPounds(): void
    {
        $mass = new Mass(BigDecimal::of('150'), Pounds::make());
        $result = $mass->toPounds();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('150')));
        self::assertInstanceOf(Pounds::class, $result->uom());
    }

    // ---------------------------------------------------------------
    // Imperial round-trip conversions
    // ---------------------------------------------------------------

    public function testRoundTripKilogramsToPoundsAndBack(): void
    {
        $original = new Mass(BigDecimal::of('75'), Kilograms::make());
        $converted = $original->toPounds();
        $roundTrip = $converted->toKilograms();

        self::assertEqualsWithDelta(75.0, (float) (string) $roundTrip->value(), 0.0001);
    }

    public function testRoundTripKilogramsToStonesAndBack(): void
    {
        $original = new Mass(BigDecimal::of('100'), Kilograms::make());
        $converted = $original->toStones();
        $roundTrip = $converted->toKilograms();

        self::assertEqualsWithDelta(100.0, (float) (string) $roundTrip->value(), 0.0001);
    }
}
