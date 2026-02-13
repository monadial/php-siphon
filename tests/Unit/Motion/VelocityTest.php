<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Motion;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Exception\ParseFailure;
use Monadial\Siphon\Exception\UnitNotFound;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Motion\Velocity;
use Monadial\Siphon\Unit\Motion\Velocity\FeetPerSecond;
use Monadial\Siphon\Unit\Motion\Velocity\KilometersPerHour;
use Monadial\Siphon\Unit\Motion\Velocity\KilometersPerSecond;
use Monadial\Siphon\Unit\Motion\Velocity\Knots;
use Monadial\Siphon\Unit\Motion\Velocity\MetersPerSecond;
use Monadial\Siphon\Unit\Motion\Velocity\MilesPerHour;
use Monadial\Siphon\Unit\Motion\Velocity\MillimetersPerSecond;
use Monadial\Siphon\Unit\Motion\VelocityUnit;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Velocity::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(VelocityUnit::class)]
#[UsesClass(MetersPerSecond::class)]
#[UsesClass(KilometersPerHour::class)]
#[UsesClass(MilesPerHour::class)]
#[UsesClass(Knots::class)]
#[UsesClass(FeetPerSecond::class)]
#[UsesClass(KilometersPerSecond::class)]
#[UsesClass(MillimetersPerSecond::class)]
final class VelocityTest extends TestCase
{
    // ---------------------------------------------------------------
    // Identity conversions
    // ---------------------------------------------------------------

    public function testIdentityMetersPerSecond(): void
    {
        $v = new Velocity(BigDecimal::of('10'), MetersPerSecond::make());
        $result = $v->toMetersPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('10')));
        self::assertInstanceOf(MetersPerSecond::class, $result->uom());
    }

    // ---------------------------------------------------------------
    // Metric conversions (exact)
    // ---------------------------------------------------------------

    public function testMetersPerSecondToKilometersPerSecond(): void
    {
        $v = new Velocity(BigDecimal::of('1000'), MetersPerSecond::make());
        $result = $v->toKilometersPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(KilometersPerSecond::class, $result->uom());
    }

    public function testKilometersPerSecondToMetersPerSecond(): void
    {
        $v = new Velocity(BigDecimal::of('1'), KilometersPerSecond::make());
        $result = $v->toMetersPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testMetersPerSecondToMillimetersPerSecond(): void
    {
        $v = new Velocity(BigDecimal::of('1'), MetersPerSecond::make());
        $result = $v->toMillimetersPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
        self::assertInstanceOf(MillimetersPerSecond::class, $result->uom());
    }

    public function testMillimetersPerSecondToMetersPerSecond(): void
    {
        $v = new Velocity(BigDecimal::of('1000'), MillimetersPerSecond::make());
        $result = $v->toMetersPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    // ---------------------------------------------------------------
    // Non-metric conversions (approximate)
    // ---------------------------------------------------------------

    public function testMetersPerSecondToKilometersPerHour(): void
    {
        $v = new Velocity(BigDecimal::of('1'), MetersPerSecond::make());
        $result = $v->toKilometersPerHour();

        self::assertEqualsWithDelta(3.6, (float) (string) $result->value(), 0.0001);
        self::assertInstanceOf(KilometersPerHour::class, $result->uom());
    }

    public function testKilometersPerHourToMetersPerSecond(): void
    {
        $v = new Velocity(BigDecimal::of('3.6'), KilometersPerHour::make());
        $result = $v->toMetersPerSecond();

        self::assertEqualsWithDelta(1.0, (float) (string) $result->value(), 0.0001);
    }

    public function testMetersPerSecondToMilesPerHour(): void
    {
        $v = new Velocity(BigDecimal::of('1'), MetersPerSecond::make());
        $result = $v->toMilesPerHour();

        self::assertEqualsWithDelta(2.23694, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(MilesPerHour::class, $result->uom());
    }

    public function testMilesPerHourToMetersPerSecond(): void
    {
        $v = new Velocity(BigDecimal::of('1'), MilesPerHour::make());
        $result = $v->toMetersPerSecond();

        self::assertEqualsWithDelta(0.44704, (float) (string) $result->value(), 0.00001);
    }

    public function testMetersPerSecondToKnots(): void
    {
        $v = new Velocity(BigDecimal::of('1'), MetersPerSecond::make());
        $result = $v->toKnots();

        self::assertEqualsWithDelta(1.94384, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(Knots::class, $result->uom());
    }

    public function testKnotsToMetersPerSecond(): void
    {
        $v = new Velocity(BigDecimal::of('1'), Knots::make());
        $result = $v->toMetersPerSecond();

        self::assertEqualsWithDelta(0.51444, (float) (string) $result->value(), 0.001);
    }

    public function testMetersPerSecondToFeetPerSecond(): void
    {
        $v = new Velocity(BigDecimal::of('1'), MetersPerSecond::make());
        $result = $v->toFeetPerSecond();

        self::assertEqualsWithDelta(3.28084, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(FeetPerSecond::class, $result->uom());
    }

    public function testFeetPerSecondToMetersPerSecond(): void
    {
        $v = new Velocity(BigDecimal::of('1'), FeetPerSecond::make());
        $result = $v->toMetersPerSecond();

        self::assertEqualsWithDelta(0.3048, (float) (string) $result->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // Cross-conversions
    // ---------------------------------------------------------------

    public function testKilometersPerHourToMilesPerHour(): void
    {
        $v = new Velocity(BigDecimal::of('100'), KilometersPerHour::make());
        $result = $v->toMilesPerHour();

        self::assertEqualsWithDelta(62.1371, (float) (string) $result->value(), 0.01);
    }

    public function testKnotsToKilometersPerHour(): void
    {
        $v = new Velocity(BigDecimal::of('1'), Knots::make());
        $result = $v->toKilometersPerHour();

        self::assertEqualsWithDelta(1.852, (float) (string) $result->value(), 0.001);
    }

    // ---------------------------------------------------------------
    // Zero value
    // ---------------------------------------------------------------

    public function testZeroValueConversion(): void
    {
        $v = new Velocity(BigDecimal::of('0'), MetersPerSecond::make());
        $result = $v->toKilometersPerHour();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0')));
    }

    // ---------------------------------------------------------------
    // Round-trip
    // ---------------------------------------------------------------

    public function testRoundTripMetersPerSecondToKilometersPerHour(): void
    {
        $original = new Velocity(BigDecimal::of('100'), MetersPerSecond::make());
        $converted = $original->toKilometersPerHour();
        $roundTrip = $converted->toMetersPerSecond();

        self::assertEqualsWithDelta(100.0, (float) (string) $roundTrip->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // Return type checks
    // ---------------------------------------------------------------

    public function testScaleToReturnsVelocityInstance(): void
    {
        $v = new Velocity(BigDecimal::of('1'), MetersPerSecond::make());
        $result = $v->toKilometersPerHour();

        self::assertInstanceOf(Velocity::class, $result);
    }

    public function testStringNotationForMetersPerSecond(): void
    {
        $v = Velocity::metersPerSecond(10);

        self::assertSame('10 m/s', (string) $v);
    }

    public function testStringNotationForKilometersPerHour(): void
    {
        $v = Velocity::metersPerSecond(10)->toKilometersPerHour();

        self::assertStringEndsWith(' km/h', (string) $v);
        self::assertEqualsWithDelta(36.0, (float) (string) $v->value(), 0.0001);
    }

    public function testScientificNotationString(): void
    {
        $v = Velocity::metersPerSecond(12345.6789);

        self::assertMatchesRegularExpression('/E\+0?4/', $v->toScientificString(4));
        self::assertStringEndsWith(' m/s', $v->toScientificString(4));
    }

    public function testExplicitUnitConversionApi(): void
    {
        $converted = Velocity::convert(10, MetersPerSecond::make(), KilometersPerHour::make());

        self::assertStringEndsWith(' km/h', (string) $converted);
        self::assertEqualsWithDelta(36.0, (float) (string) $converted->value(), 0.0001);
    }

    /**
     * @throws ParseFailure
     * @throws UnitNotFound
     */
    public function testParseFromStringWithSlashNotation(): void
    {
        $parsed = Velocity::parse('100 km/h');

        self::assertInstanceOf(KilometersPerHour::class, $parsed->uom());
        self::assertTrue($parsed->value()->isEqualTo(BigDecimal::of('100')));
        self::assertSame('100 km/h', (string) $parsed);
    }
}
