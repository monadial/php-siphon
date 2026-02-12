<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Electrical;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricCharge;
use Monadial\Siphon\Unit\Electrical\ElectricCharge\AmpereHours;
use Monadial\Siphon\Unit\Electrical\ElectricCharge\Coulombs;
use Monadial\Siphon\Unit\Electrical\ElectricCharge\Microcoulombs;
use Monadial\Siphon\Unit\Electrical\ElectricCharge\MilliampereHours;
use Monadial\Siphon\Unit\Electrical\ElectricCharge\Millicoulombs;
use Monadial\Siphon\Unit\Electrical\ElectricCharge\Nanocoulombs;
use Monadial\Siphon\Unit\Electrical\ElectricCharge\Picocoulombs;
use Monadial\Siphon\Unit\Electrical\ElectricChargeUnit;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ElectricCharge::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(Coulombs::class)]
#[UsesClass(Millicoulombs::class)]
#[UsesClass(Microcoulombs::class)]
#[UsesClass(Nanocoulombs::class)]
#[UsesClass(Picocoulombs::class)]
#[UsesClass(AmpereHours::class)]
#[UsesClass(MilliampereHours::class)]
#[UsesClass(ElectricChargeUnit::class)]
final class ElectricChargeTest extends TestCase
{
    // ---------------------------------------------------------------
    // Construction and basic accessors
    // ---------------------------------------------------------------

    public function testConstructionAndValueAccess(): void
    {
        $charge = new ElectricCharge(BigDecimal::of('100'), Coulombs::make());

        self::assertTrue($charge->value()->isEqualTo(BigDecimal::of('100')));
        self::assertInstanceOf(Coulombs::class, $charge->uom());
    }

    // ---------------------------------------------------------------
    // Identity conversions
    // ---------------------------------------------------------------

    public function testIdentityConversion(): void
    {
        $charge = new ElectricCharge(BigDecimal::of('5'), Coulombs::make());
        $result = $charge->toCoulombs();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5')));
    }

    // ---------------------------------------------------------------
    // Coulombs to metric sub-units
    // ---------------------------------------------------------------

    public function testCoulombsToMillicoulombs(): void
    {
        $charge = new ElectricCharge(BigDecimal::of('1'), Coulombs::make());
        $result = $charge->toMillicoulombs();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testCoulombsToMicrocoulombs(): void
    {
        $charge = new ElectricCharge(BigDecimal::of('1'), Coulombs::make());
        $result = $charge->toMicrocoulombs();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    public function testCoulombsToNanocoulombs(): void
    {
        $charge = new ElectricCharge(BigDecimal::of('1'), Coulombs::make());
        $result = $charge->toNanocoulombs();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000000')));
    }

    public function testCoulombsToPicocoulombs(): void
    {
        $charge = new ElectricCharge(BigDecimal::of('1'), Coulombs::make());
        $result = $charge->toPicocoulombs();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000000000')));
    }

    // ---------------------------------------------------------------
    // Sub-units back to coulombs
    // ---------------------------------------------------------------

    public function testMillicoulombsToCoulombs(): void
    {
        $charge = new ElectricCharge(BigDecimal::of('500'), Millicoulombs::make());
        $result = $charge->toCoulombs();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.5')));
    }

    public function testMicrocoulombsToCoulombs(): void
    {
        $charge = new ElectricCharge(BigDecimal::of('1000000'), Microcoulombs::make());
        $result = $charge->toCoulombs();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    // ---------------------------------------------------------------
    // Ampere-hours conversions
    // ---------------------------------------------------------------

    public function testCoulombsToAmpereHours(): void
    {
        $charge = new ElectricCharge(BigDecimal::of('3600'), Coulombs::make());
        $result = $charge->toAmpereHours();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testAmpereHoursToCoulombs(): void
    {
        $charge = new ElectricCharge(BigDecimal::of('1'), AmpereHours::make());
        $result = $charge->toCoulombs();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('3600')));
    }

    public function testCoulombsToMilliampereHours(): void
    {
        $charge = new ElectricCharge(BigDecimal::of('3.6'), Coulombs::make());
        $result = $charge->toMilliampereHours();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testMilliampereHoursToCoulombs(): void
    {
        $charge = new ElectricCharge(BigDecimal::of('1'), MilliampereHours::make());
        $result = $charge->toCoulombs();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('3.6')));
    }

    public function testAmpereHoursToMilliampereHours(): void
    {
        $charge = new ElectricCharge(BigDecimal::of('1'), AmpereHours::make());
        $result = $charge->toMilliampereHours();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    // ---------------------------------------------------------------
    // Cross-conversions
    // ---------------------------------------------------------------

    public function testNanocoulombsToMillicoulombs(): void
    {
        $charge = new ElectricCharge(BigDecimal::of('1000000'), Nanocoulombs::make());
        $result = $charge->toMillicoulombs();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testPicocoulombsToMicrocoulombs(): void
    {
        $charge = new ElectricCharge(BigDecimal::of('1000000'), Picocoulombs::make());
        $result = $charge->toMicrocoulombs();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    // ---------------------------------------------------------------
    // Round-trip conversions
    // ---------------------------------------------------------------

    public function testRoundTripCoulombsToAmpereHoursAndBack(): void
    {
        $original = new ElectricCharge(BigDecimal::of('7200'), Coulombs::make());
        $converted = $original->toAmpereHours();
        $roundTrip = $converted->toCoulombs();

        self::assertTrue($roundTrip->value()->isEqualTo(BigDecimal::of('7200')));
    }

    public function testRoundTripMillicoulombsToPicocoulombsAndBack(): void
    {
        $original = new ElectricCharge(BigDecimal::of('5'), Millicoulombs::make());
        $converted = $original->toPicocoulombs();
        $roundTrip = $converted->toMillicoulombs();

        self::assertTrue($roundTrip->value()->isEqualTo(BigDecimal::of('5')));
    }

    // ---------------------------------------------------------------
    // Return type / instance checks
    // ---------------------------------------------------------------

    public function testScaleToReturnsElectricChargeInstance(): void
    {
        $charge = new ElectricCharge(BigDecimal::of('1'), Coulombs::make());
        $result = $charge->toMillicoulombs();

        self::assertInstanceOf(ElectricCharge::class, $result);
    }

    public function testConversionPreservesUnitOfMeasure(): void
    {
        $charge = new ElectricCharge(BigDecimal::of('1'), Coulombs::make());

        self::assertInstanceOf(Millicoulombs::class, $charge->toMillicoulombs()->uom());
        self::assertInstanceOf(Microcoulombs::class, $charge->toMicrocoulombs()->uom());
        self::assertInstanceOf(Nanocoulombs::class, $charge->toNanocoulombs()->uom());
        self::assertInstanceOf(Picocoulombs::class, $charge->toPicocoulombs()->uom());
        self::assertInstanceOf(AmpereHours::class, $charge->toAmpereHours()->uom());
        self::assertInstanceOf(MilliampereHours::class, $charge->toMilliampereHours()->uom());
    }

    // ---------------------------------------------------------------
    // Zero value
    // ---------------------------------------------------------------

    public function testZeroValueConversion(): void
    {
        $charge = new ElectricCharge(BigDecimal::of('0'), Coulombs::make());
        $result = $charge->toAmpereHours();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0')));
    }
}
