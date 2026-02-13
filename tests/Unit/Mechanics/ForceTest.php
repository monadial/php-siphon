<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Mechanics;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\Force;
use Monadial\Siphon\Unit\Mechanics\Force\Dynes;
use Monadial\Siphon\Unit\Mechanics\Force\KilogramForce;
use Monadial\Siphon\Unit\Mechanics\Force\Kilonewtons;
use Monadial\Siphon\Unit\Mechanics\Force\Meganewtons;
use Monadial\Siphon\Unit\Mechanics\Force\Millinewtons;
use Monadial\Siphon\Unit\Mechanics\Force\Newtons;
use Monadial\Siphon\Unit\Mechanics\Force\PoundForce;
use Monadial\Siphon\Unit\Mechanics\ForceUnit;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Force::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(ForceUnit::class)]
#[UsesClass(Newtons::class)]
#[UsesClass(Kilonewtons::class)]
#[UsesClass(Meganewtons::class)]
#[UsesClass(Millinewtons::class)]
#[UsesClass(Dynes::class)]
#[UsesClass(PoundForce::class)]
#[UsesClass(KilogramForce::class)]
final class ForceTest extends TestCase
{
    // ---------------------------------------------------------------
    // Identity conversions
    // ---------------------------------------------------------------

    public function testIdentityNewtons(): void
    {
        $f = new Force(BigDecimal::of('100'), Newtons::make());
        $result = $f->toNewtons();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('100')));
        self::assertInstanceOf(Newtons::class, $result->uom());
    }

    // ---------------------------------------------------------------
    // Metric conversions (exact)
    // ---------------------------------------------------------------

    public function testNewtonsToKilonewtons(): void
    {
        $f = new Force(BigDecimal::of('1000'), Newtons::make());
        $result = $f->toKilonewtons();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(Kilonewtons::class, $result->uom());
    }

    public function testKilonewtonsToNewtons(): void
    {
        $f = new Force(BigDecimal::of('1'), Kilonewtons::make());
        $result = $f->toNewtons();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testNewtonsToMeganewtons(): void
    {
        $f = new Force(BigDecimal::of('1000000'), Newtons::make());
        $result = $f->toMeganewtons();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(Meganewtons::class, $result->uom());
    }

    public function testMeganewtonsToNewtons(): void
    {
        $f = new Force(BigDecimal::of('1'), Meganewtons::make());
        $result = $f->toNewtons();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    public function testNewtonsToMillinewtons(): void
    {
        $f = new Force(BigDecimal::of('1'), Newtons::make());
        $result = $f->toMillinewtons();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
        self::assertInstanceOf(Millinewtons::class, $result->uom());
    }

    public function testMillinewtonsToNewtons(): void
    {
        $f = new Force(BigDecimal::of('1000'), Millinewtons::make());
        $result = $f->toNewtons();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    // ---------------------------------------------------------------
    // Non-metric conversions (approximate)
    // ---------------------------------------------------------------

    public function testNewtonsToDynes(): void
    {
        $f = new Force(BigDecimal::of('1'), Newtons::make());
        $result = $f->toDynes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('100000')));
        self::assertInstanceOf(Dynes::class, $result->uom());
    }

    public function testDynesToNewtons(): void
    {
        $f = new Force(BigDecimal::of('100000'), Dynes::make());
        $result = $f->toNewtons();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testNewtonsToPoundForce(): void
    {
        $f = new Force(BigDecimal::of('1'), Newtons::make());
        $result = $f->toPoundForce();

        self::assertEqualsWithDelta(0.22481, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(PoundForce::class, $result->uom());
    }

    public function testPoundForceToNewtons(): void
    {
        $f = new Force(BigDecimal::of('1'), PoundForce::make());
        $result = $f->toNewtons();

        self::assertEqualsWithDelta(4.44822, (float) (string) $result->value(), 0.001);
    }

    public function testNewtonsToKilogramForce(): void
    {
        $f = new Force(BigDecimal::of('9.80665'), Newtons::make());
        $result = $f->toKilogramForce();

        self::assertEqualsWithDelta(1.0, (float) (string) $result->value(), 0.0001);
        self::assertInstanceOf(KilogramForce::class, $result->uom());
    }

    public function testKilogramForceToNewtons(): void
    {
        $f = new Force(BigDecimal::of('1'), KilogramForce::make());
        $result = $f->toNewtons();

        self::assertEqualsWithDelta(9.80665, (float) (string) $result->value(), 0.00001);
    }

    // ---------------------------------------------------------------
    // Zero value
    // ---------------------------------------------------------------

    public function testZeroValueConversion(): void
    {
        $f = new Force(BigDecimal::of('0'), Newtons::make());
        $result = $f->toPoundForce();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0')));
    }

    // ---------------------------------------------------------------
    // Round-trip
    // ---------------------------------------------------------------

    public function testRoundTripNewtonsToPoundForce(): void
    {
        $original = new Force(BigDecimal::of('100'), Newtons::make());
        $converted = $original->toPoundForce();
        $roundTrip = $converted->toNewtons();

        self::assertEqualsWithDelta(100.0, (float) (string) $roundTrip->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // Return type checks
    // ---------------------------------------------------------------

    public function testScaleToReturnsForceInstance(): void
    {
        $f = new Force(BigDecimal::of('1'), Newtons::make());
        $result = $f->toKilonewtons();

        self::assertInstanceOf(Force::class, $result);
    }
}
