<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Space;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Space\SolidAngle;
use Monadial\Siphon\Unit\Space\SolidAngle\SquareDegrees;
use Monadial\Siphon\Unit\Space\SolidAngle\Steradians;
use Monadial\Siphon\Unit\Space\SolidAngleUnit;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SolidAngle::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(Steradians::class)]
#[UsesClass(SquareDegrees::class)]
#[UsesClass(SolidAngleUnit::class)]
final class SolidAngleTest extends TestCase
{
    // ---------------------------------------------------------------
    // Construction and basic accessors
    // ---------------------------------------------------------------

    public function testConstructionAndValueAccess(): void
    {
        $solidAngle = new SolidAngle(BigDecimal::of('1'), Steradians::make());

        self::assertTrue($solidAngle->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(Steradians::class, $solidAngle->uom());
    }

    // ---------------------------------------------------------------
    // Identity conversions
    // ---------------------------------------------------------------

    public function testIdentityConversionSteradians(): void
    {
        $solidAngle = new SolidAngle(BigDecimal::of('2.5'), Steradians::make());
        $result = $solidAngle->toSteradians();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('2.5')));
        self::assertInstanceOf(Steradians::class, $result->uom());
    }

    public function testIdentityConversionSquareDegrees(): void
    {
        $solidAngle = new SolidAngle(BigDecimal::of('100'), SquareDegrees::make());
        $result = $solidAngle->toSquareDegrees();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('100')));
    }

    // ---------------------------------------------------------------
    // Steradians to square degrees and back
    // ---------------------------------------------------------------

    public function testSteradiansToSquareDegrees(): void
    {
        $solidAngle = new SolidAngle(BigDecimal::of('1'), Steradians::make());
        $result = $solidAngle->toSquareDegrees();

        // 1 steradian ≈ 3282.80635 square degrees
        self::assertEqualsWithDelta(
            3282.80635,
            (float) (string) $result->value(),
            1e-2,
        );
    }

    public function testSquareDegreesToSteradians(): void
    {
        $solidAngle = new SolidAngle(BigDecimal::of('3282.80635'), SquareDegrees::make());
        $result = $solidAngle->toSteradians();

        self::assertEqualsWithDelta(
            1.0,
            (float) (string) $result->value(),
            1e-4,
        );
    }

    // ---------------------------------------------------------------
    // Round-trip conversions
    // ---------------------------------------------------------------

    public function testRoundTripSteradiansToSquareDegreesAndBack(): void
    {
        $original = new SolidAngle(BigDecimal::of('4'), Steradians::make());
        $converted = $original->toSquareDegrees();
        $roundTrip = $converted->toSteradians();

        self::assertEqualsWithDelta(
            4.0,
            (float) (string) $roundTrip->value(),
            1e-10,
        );
    }

    // ---------------------------------------------------------------
    // Return type / instance checks
    // ---------------------------------------------------------------

    public function testScaleToReturnsSolidAngleInstance(): void
    {
        $solidAngle = new SolidAngle(BigDecimal::of('1'), Steradians::make());
        $result = $solidAngle->toSquareDegrees();

        self::assertInstanceOf(SolidAngle::class, $result);
    }

    public function testConversionPreservesUnitOfMeasure(): void
    {
        $solidAngle = new SolidAngle(BigDecimal::of('1'), Steradians::make());

        self::assertInstanceOf(SquareDegrees::class, $solidAngle->toSquareDegrees()->uom());
    }

    // ---------------------------------------------------------------
    // Zero value
    // ---------------------------------------------------------------

    public function testZeroValueConversion(): void
    {
        $solidAngle = new SolidAngle(BigDecimal::of('0'), Steradians::make());
        $result = $solidAngle->toSquareDegrees();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0')));
    }

    // ---------------------------------------------------------------
    // Typed factory methods (plural forms)
    // ---------------------------------------------------------------

    public function testSquareDegreesFactory(): void
    {
        self::assertInstanceOf(SquareDegrees::class, SolidAngle::squareDegrees(1)->uom());
    }

    public function testSteradiansFactory(): void
    {
        self::assertInstanceOf(Steradians::class, SolidAngle::steradians(1)->uom());
    }

    // ---------------------------------------------------------------
    // Typed factory methods (singular forms)
    // ---------------------------------------------------------------

    public function testSquareDegreeFactory(): void
    {
        self::assertInstanceOf(SquareDegrees::class, SolidAngle::squareDegree(1)->uom());
    }

    public function testSteradianFactory(): void
    {
        self::assertInstanceOf(Steradians::class, SolidAngle::steradian(1)->uom());
    }
}
