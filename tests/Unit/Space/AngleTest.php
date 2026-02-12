<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Space;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Space\Angle;
use Monadial\Siphon\Unit\Space\Angle\Arcminutes;
use Monadial\Siphon\Unit\Space\Angle\Arcseconds;
use Monadial\Siphon\Unit\Space\Angle\Degrees;
use Monadial\Siphon\Unit\Space\Angle\Gradians;
use Monadial\Siphon\Unit\Space\Angle\Radians;
use Monadial\Siphon\Unit\Space\Angle\Turns;
use Monadial\Siphon\Unit\Space\AngleUnit;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Angle::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(Radians::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Gradians::class)]
#[UsesClass(Turns::class)]
#[UsesClass(Arcminutes::class)]
#[UsesClass(Arcseconds::class)]
#[UsesClass(AngleUnit::class)]
final class AngleTest extends TestCase
{
    // ---------------------------------------------------------------
    // Construction and basic accessors
    // ---------------------------------------------------------------

    public function testConstructionAndValueAccess(): void
    {
        $angle = new Angle(BigDecimal::of('1'), Radians::make());

        self::assertTrue($angle->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(Radians::class, $angle->uom());
    }

    // ---------------------------------------------------------------
    // Identity conversions
    // ---------------------------------------------------------------

    public function testIdentityConversionRadians(): void
    {
        $angle = new Angle(BigDecimal::of('3.14'), Radians::make());
        $result = $angle->toRadians();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('3.14')));
        self::assertInstanceOf(Radians::class, $result->uom());
    }

    public function testIdentityConversionDegrees(): void
    {
        $angle = new Angle(BigDecimal::of('90'), Degrees::make());
        $result = $angle->toDegrees();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('90')));
    }

    // ---------------------------------------------------------------
    // Degrees to radians and back
    // ---------------------------------------------------------------

    public function testDegreesToRadians180(): void
    {
        $angle = new Angle(BigDecimal::of('180'), Degrees::make());
        $result = $angle->toRadians();

        // 180 degrees = pi radians ≈ 3.14159265358979323846
        self::assertEqualsWithDelta(
            3.14159265358979323846,
            (float) (string) $result->value(),
            1e-10,
        );
    }

    public function testRadiansToDegrees(): void
    {
        $angle = new Angle(BigDecimal::of('1'), Radians::make());
        $result = $angle->toDegrees();

        // 1 radian ≈ 57.2957795130823 degrees
        self::assertEqualsWithDelta(
            57.29577951308232,
            (float) (string) $result->value(),
            1e-6,
        );
    }

    // ---------------------------------------------------------------
    // Turns conversions
    // ---------------------------------------------------------------

    public function testTurnsToRadians(): void
    {
        $angle = new Angle(BigDecimal::of('1'), Turns::make());
        $result = $angle->toRadians();

        // 1 turn = 2*pi radians ≈ 6.28318530717958647693
        self::assertEqualsWithDelta(
            6.28318530717958647693,
            (float) (string) $result->value(),
            1e-10,
        );
    }

    public function testTurnsToDegrees(): void
    {
        $angle = new Angle(BigDecimal::of('1'), Turns::make());
        $result = $angle->toDegrees();

        // 1 turn = 360 degrees
        self::assertEqualsWithDelta(
            360.0,
            (float) (string) $result->value(),
            1e-6,
        );
    }

    // ---------------------------------------------------------------
    // Gradians conversions
    // ---------------------------------------------------------------

    public function testGradiansToDegrees(): void
    {
        $angle = new Angle(BigDecimal::of('200'), Gradians::make());
        $result = $angle->toDegrees();

        // 200 gradians = 180 degrees
        self::assertEqualsWithDelta(
            180.0,
            (float) (string) $result->value(),
            1e-6,
        );
    }

    public function testGradiansToRadians(): void
    {
        $angle = new Angle(BigDecimal::of('200'), Gradians::make());
        $result = $angle->toRadians();

        // 200 gradians = pi radians
        self::assertEqualsWithDelta(
            3.14159265358979323846,
            (float) (string) $result->value(),
            1e-10,
        );
    }

    // ---------------------------------------------------------------
    // Arcminutes and arcseconds
    // ---------------------------------------------------------------

    public function testDegreesToArcminutes(): void
    {
        $angle = new Angle(BigDecimal::of('1'), Degrees::make());
        $result = $angle->toArcminutes();

        // 1 degree = 60 arcminutes
        self::assertEqualsWithDelta(
            60.0,
            (float) (string) $result->value(),
            1e-6,
        );
    }

    public function testDegreesToArcseconds(): void
    {
        $angle = new Angle(BigDecimal::of('1'), Degrees::make());
        $result = $angle->toArcseconds();

        // 1 degree = 3600 arcseconds
        self::assertEqualsWithDelta(
            3600.0,
            (float) (string) $result->value(),
            1e-4,
        );
    }

    public function testArcminutesToArcseconds(): void
    {
        $angle = new Angle(BigDecimal::of('1'), Arcminutes::make());
        $result = $angle->toArcseconds();

        // 1 arcminute = 60 arcseconds
        self::assertEqualsWithDelta(
            60.0,
            (float) (string) $result->value(),
            1e-4,
        );
    }

    // ---------------------------------------------------------------
    // Round-trip conversions
    // ---------------------------------------------------------------

    public function testRoundTripDegreesToRadiansAndBack(): void
    {
        $original = new Angle(BigDecimal::of('45'), Degrees::make());
        $converted = $original->toRadians();
        $roundTrip = $converted->toDegrees();

        self::assertEqualsWithDelta(
            45.0,
            (float) (string) $roundTrip->value(),
            1e-10,
        );
    }

    public function testRoundTripTurnsToGradiansAndBack(): void
    {
        $original = new Angle(BigDecimal::of('2'), Turns::make());
        $converted = $original->toGradians();
        $roundTrip = $converted->toTurns();

        self::assertEqualsWithDelta(
            2.0,
            (float) (string) $roundTrip->value(),
            1e-10,
        );
    }

    // ---------------------------------------------------------------
    // Return type / instance checks
    // ---------------------------------------------------------------

    public function testScaleToReturnsAngleInstance(): void
    {
        $angle = new Angle(BigDecimal::of('1'), Radians::make());
        $result = $angle->toDegrees();

        self::assertInstanceOf(Angle::class, $result);
    }

    public function testConversionPreservesUnitOfMeasure(): void
    {
        $angle = new Angle(BigDecimal::of('1'), Radians::make());

        self::assertInstanceOf(Degrees::class, $angle->toDegrees()->uom());
        self::assertInstanceOf(Gradians::class, $angle->toGradians()->uom());
        self::assertInstanceOf(Turns::class, $angle->toTurns()->uom());
        self::assertInstanceOf(Arcminutes::class, $angle->toArcminutes()->uom());
        self::assertInstanceOf(Arcseconds::class, $angle->toArcseconds()->uom());
    }

    // ---------------------------------------------------------------
    // Zero value
    // ---------------------------------------------------------------

    public function testZeroValueConversion(): void
    {
        $angle = new Angle(BigDecimal::of('0'), Radians::make());
        $result = $angle->toDegrees();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0')));
    }
}
