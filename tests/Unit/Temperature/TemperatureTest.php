<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Temperature;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Temperature\Temperature;
use Monadial\Siphon\Unit\Temperature\Temperature\Celsius;
use Monadial\Siphon\Unit\Temperature\Temperature\Fahrenheit;
use Monadial\Siphon\Unit\Temperature\Temperature\Kelvins;
use Monadial\Siphon\Unit\Temperature\Temperature\Kilokelvins;
use Monadial\Siphon\Unit\Temperature\Temperature\Millikelvins;
use Monadial\Siphon\Unit\Temperature\Temperature\Rankine;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Temperature::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(Millikelvins::class)]
#[UsesClass(Kelvins::class)]
#[UsesClass(Kilokelvins::class)]
#[UsesClass(Celsius::class)]
#[UsesClass(Fahrenheit::class)]
#[UsesClass(Rankine::class)]
final class TemperatureTest extends TestCase
{
    public function testIdentityConversion(): void
    {
        $temp = new Temperature(BigDecimal::of('300'), Kelvins::make());
        $result = $temp->toKelvins();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('300')));
    }

    public function testKelvinsToMillikelvins(): void
    {
        $temp = new Temperature(BigDecimal::of('1'), Kelvins::make());
        $result = $temp->toMillikelvins();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testMillikelvinsToKelvins(): void
    {
        $temp = new Temperature(BigDecimal::of('250'), Millikelvins::make());
        $result = $temp->toKelvins();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.25')));
    }

    public function testKelvinsToKilokelvins(): void
    {
        $temp = new Temperature(BigDecimal::of('5000'), Kelvins::make());
        $result = $temp->toKilokelvins();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5')));
    }

    public function testKilokelvinsToKelvins(): void
    {
        $temp = new Temperature(BigDecimal::of('2.5'), Kilokelvins::make());
        $result = $temp->toKelvins();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('2500')));
    }

    public function testKilokelvinsToMillikelvins(): void
    {
        $temp = new Temperature(BigDecimal::of('1'), Kilokelvins::make());
        $result = $temp->toMillikelvins();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    public function testZeroCelsiusToKelvins(): void
    {
        $temp = new Temperature(BigDecimal::of('0'), Celsius::make());
        $result = $temp->toKelvins();

        self::assertTrue(
            $result->value()->isEqualTo(BigDecimal::of('273.15')),
            'Expected 273.15, got ' . $result->value(),
        );
    }

    public function testHundredCelsiusToKelvins(): void
    {
        $temp = new Temperature(BigDecimal::of('100'), Celsius::make());
        $result = $temp->toKelvins();

        self::assertTrue(
            $result->value()->isEqualTo(BigDecimal::of('373.15')),
            'Expected 373.15, got ' . $result->value(),
        );
    }

    public function testKelvinsToCelsius(): void
    {
        $temp = new Temperature(BigDecimal::of('273.15'), Kelvins::make());
        $result = $temp->toCelsius();

        self::assertTrue(
            $result->value()->isEqualTo(BigDecimal::of('0')),
            'Expected 0, got ' . $result->value(),
        );
    }

    public function testThirtyTwoFahrenheitToKelvins(): void
    {
        // 32°F = 0°C = 273.15 K
        $temp = new Temperature(BigDecimal::of('32'), Fahrenheit::make());
        $result = $temp->toKelvins();

        // (32 + 459.67) * 5/9 = 491.67 * 5/9 = 273.15
        self::assertEqualsWithDelta(273.15, (float) (string) $result->value(), 0.01);
    }

    public function testTwoTwelveFahrenheitToKelvins(): void
    {
        // 212°F = 100°C = 373.15 K
        $temp = new Temperature(BigDecimal::of('212'), Fahrenheit::make());
        $result = $temp->toKelvins();

        self::assertEqualsWithDelta(373.15, (float) (string) $result->value(), 0.01);
    }

    public function testKelvinsToFahrenheit(): void
    {
        $temp = new Temperature(BigDecimal::of('273.15'), Kelvins::make());
        $result = $temp->toFahrenheit();

        // 273.15 / (5/9) - 459.67 = 273.15 * 9/5 - 459.67 = 491.67 - 459.67 = 32
        self::assertEqualsWithDelta(32.0, (float) (string) $result->value(), 0.01);
    }

    public function testCelsiusToFahrenheit(): void
    {
        // 100°C = 212°F
        $temp = new Temperature(BigDecimal::of('100'), Celsius::make());
        $result = $temp->toFahrenheit();

        self::assertEqualsWithDelta(212.0, (float) (string) $result->value(), 0.01);
    }

    public function testFahrenheitToCelsius(): void
    {
        // 32°F = 0°C
        $temp = new Temperature(BigDecimal::of('32'), Fahrenheit::make());
        $result = $temp->toCelsius();

        self::assertEqualsWithDelta(0.0, (float) (string) $result->value(), 0.01);
    }

    public function testKelvinsToRankine(): void
    {
        // 273.15 K = 491.67 R
        $temp = new Temperature(BigDecimal::of('273.15'), Kelvins::make());
        $result = $temp->toRankine();

        self::assertEqualsWithDelta(491.67, (float) (string) $result->value(), 0.01);
    }

    public function testRankineToKelvins(): void
    {
        // 491.67 R = 273.15 K
        $temp = new Temperature(BigDecimal::of('491.67'), Rankine::make());
        $result = $temp->toKelvins();

        self::assertEqualsWithDelta(273.15, (float) (string) $result->value(), 0.01);
    }

    public function testFahrenheitToRankine(): void
    {
        // 32°F = 491.67 R (same factor, different offset)
        $temp = new Temperature(BigDecimal::of('32'), Fahrenheit::make());
        $result = $temp->toRankine();

        self::assertEqualsWithDelta(491.67, (float) (string) $result->value(), 0.01);
    }

    public function testCelsiusIdentityRoundTrip(): void
    {
        $temp = new Temperature(BigDecimal::of('25'), Celsius::make());
        $result = $temp->toKelvins()->toCelsius();

        self::assertEqualsWithDelta(25.0, (float) (string) $result->value(), 0.01);
    }

    public function testFahrenheitIdentityRoundTrip(): void
    {
        $temp = new Temperature(BigDecimal::of('72'), Fahrenheit::make());
        $result = $temp->toKelvins()->toFahrenheit();

        self::assertEqualsWithDelta(72.0, (float) (string) $result->value(), 0.01);
    }
}
