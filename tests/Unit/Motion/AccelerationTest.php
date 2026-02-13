<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Motion;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Motion\Acceleration;
use Monadial\Siphon\Unit\Motion\Acceleration\FeetPerSecondSquared;
use Monadial\Siphon\Unit\Motion\Acceleration\MetersPerSecondSquared;
use Monadial\Siphon\Unit\Motion\Acceleration\StandardGravity;
use Monadial\Siphon\Unit\Motion\AccelerationUnit;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Acceleration::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(AccelerationUnit::class)]
#[UsesClass(MetersPerSecondSquared::class)]
#[UsesClass(FeetPerSecondSquared::class)]
#[UsesClass(StandardGravity::class)]
final class AccelerationTest extends TestCase
{
    // ---------------------------------------------------------------
    // Identity conversions
    // ---------------------------------------------------------------

    public function testIdentityMetersPerSecondSquared(): void
    {
        $a = new Acceleration(BigDecimal::of('9.81'), MetersPerSecondSquared::make());
        $result = $a->toMetersPerSecondSquared();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('9.81')));
        self::assertInstanceOf(MetersPerSecondSquared::class, $result->uom());
    }

    // ---------------------------------------------------------------
    // Conversions to/from base
    // ---------------------------------------------------------------

    public function testMetersPerSecondSquaredToFeetPerSecondSquared(): void
    {
        $a = new Acceleration(BigDecimal::of('1'), MetersPerSecondSquared::make());
        $result = $a->toFeetPerSecondSquared();

        self::assertEqualsWithDelta(3.28084, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(FeetPerSecondSquared::class, $result->uom());
    }

    public function testFeetPerSecondSquaredToMetersPerSecondSquared(): void
    {
        $a = new Acceleration(BigDecimal::of('1'), FeetPerSecondSquared::make());
        $result = $a->toMetersPerSecondSquared();

        self::assertEqualsWithDelta(0.3048, (float) (string) $result->value(), 0.0001);
    }

    public function testMetersPerSecondSquaredToStandardGravity(): void
    {
        $a = new Acceleration(BigDecimal::of('9.80665'), MetersPerSecondSquared::make());
        $result = $a->toStandardGravity();

        self::assertEqualsWithDelta(1.0, (float) (string) $result->value(), 0.0001);
        self::assertInstanceOf(StandardGravity::class, $result->uom());
    }

    public function testStandardGravityToMetersPerSecondSquared(): void
    {
        $a = new Acceleration(BigDecimal::of('1'), StandardGravity::make());
        $result = $a->toMetersPerSecondSquared();

        self::assertEqualsWithDelta(9.80665, (float) (string) $result->value(), 0.00001);
    }

    // ---------------------------------------------------------------
    // Cross-conversions
    // ---------------------------------------------------------------

    public function testStandardGravityToFeetPerSecondSquared(): void
    {
        $a = new Acceleration(BigDecimal::of('1'), StandardGravity::make());
        $result = $a->toFeetPerSecondSquared();

        self::assertEqualsWithDelta(32.174, (float) (string) $result->value(), 0.01);
    }

    // ---------------------------------------------------------------
    // Zero value
    // ---------------------------------------------------------------

    public function testZeroValueConversion(): void
    {
        $a = new Acceleration(BigDecimal::of('0'), MetersPerSecondSquared::make());
        $result = $a->toStandardGravity();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0')));
    }

    // ---------------------------------------------------------------
    // Round-trip
    // ---------------------------------------------------------------

    public function testRoundTripMetersPerSecondSquaredToStandardGravity(): void
    {
        $original = new Acceleration(BigDecimal::of('50'), MetersPerSecondSquared::make());
        $converted = $original->toStandardGravity();
        $roundTrip = $converted->toMetersPerSecondSquared();

        self::assertEqualsWithDelta(50.0, (float) (string) $roundTrip->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // Return type checks
    // ---------------------------------------------------------------

    public function testScaleToReturnsAccelerationInstance(): void
    {
        $a = new Acceleration(BigDecimal::of('1'), MetersPerSecondSquared::make());
        $result = $a->toStandardGravity();

        self::assertInstanceOf(Acceleration::class, $result);
    }

    // ---------------------------------------------------------------
    // Factory method tests
    // ---------------------------------------------------------------

    public function testFactoryFeetPerSecondSquared(): void
    {
        $q = Acceleration::feetPerSecondSquared(1);
        self::assertInstanceOf(FeetPerSecondSquared::class, $q->uom());
    }

    public function testFactoryMetersPerSecondSquared(): void
    {
        $q = Acceleration::metersPerSecondSquared(1);
        self::assertInstanceOf(MetersPerSecondSquared::class, $q->uom());
    }

    public function testFactoryStandardGravity(): void
    {
        $q = Acceleration::standardGravity(1);
        self::assertInstanceOf(StandardGravity::class, $q->uom());
    }

    // ---------------------------------------------------------------
    // Conversion method tests
    // ---------------------------------------------------------------

    public function testToMetersPerSecondSquared(): void
    {
        $result = Acceleration::standardGravity(1)->toMetersPerSecondSquared();
        self::assertInstanceOf(MetersPerSecondSquared::class, $result->uom());
    }

    public function testToFeetPerSecondSquared(): void
    {
        $result = Acceleration::metersPerSecondSquared(1)->toFeetPerSecondSquared();
        self::assertInstanceOf(FeetPerSecondSquared::class, $result->uom());
    }

    public function testToStandardGravity(): void
    {
        $result = Acceleration::metersPerSecondSquared(1)->toStandardGravity();
        self::assertInstanceOf(StandardGravity::class, $result->uom());
    }
}
