<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Electrical;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricalConductance;
use Monadial\Siphon\Unit\Electrical\ElectricalConductance\Microsiemens;
use Monadial\Siphon\Unit\Electrical\ElectricalConductance\Millisiemens;
use Monadial\Siphon\Unit\Electrical\ElectricalConductance\Siemens;
use Monadial\Siphon\Unit\Electrical\ElectricalConductanceUnit;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ElectricalConductance::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(Siemens::class)]
#[UsesClass(Millisiemens::class)]
#[UsesClass(Microsiemens::class)]
#[UsesClass(ElectricalConductanceUnit::class)]
final class ElectricalConductanceTest extends TestCase
{
    // ---------------------------------------------------------------
    // Construction and basic accessors
    // ---------------------------------------------------------------

    public function testConstructionAndValueAccess(): void
    {
        $conductance = new ElectricalConductance(BigDecimal::of('10'), Siemens::make());

        self::assertTrue($conductance->value()->isEqualTo(BigDecimal::of('10')));
        self::assertInstanceOf(Siemens::class, $conductance->uom());
    }

    // ---------------------------------------------------------------
    // Identity conversions
    // ---------------------------------------------------------------

    public function testIdentityConversion(): void
    {
        $conductance = new ElectricalConductance(BigDecimal::of('5'), Siemens::make());
        $result = $conductance->toSiemens();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5')));
    }

    // ---------------------------------------------------------------
    // Siemens to other units
    // ---------------------------------------------------------------

    public function testSiemensToMillisiemens(): void
    {
        $conductance = new ElectricalConductance(BigDecimal::of('1'), Siemens::make());
        $result = $conductance->toMillisiemens();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testSiemensToMicrosiemens(): void
    {
        $conductance = new ElectricalConductance(BigDecimal::of('1'), Siemens::make());
        $result = $conductance->toMicrosiemens();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    // ---------------------------------------------------------------
    // Other units to siemens
    // ---------------------------------------------------------------

    public function testMillisiemensToSiemens(): void
    {
        $conductance = new ElectricalConductance(BigDecimal::of('500'), Millisiemens::make());
        $result = $conductance->toSiemens();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.5')));
    }

    public function testMicrosiemensToSiemens(): void
    {
        $conductance = new ElectricalConductance(BigDecimal::of('1000000'), Microsiemens::make());
        $result = $conductance->toSiemens();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    // ---------------------------------------------------------------
    // Cross-conversions
    // ---------------------------------------------------------------

    public function testMillisiemensToMicrosiemens(): void
    {
        $conductance = new ElectricalConductance(BigDecimal::of('1'), Millisiemens::make());
        $result = $conductance->toMicrosiemens();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testMicrosiemensToMillisiemens(): void
    {
        $conductance = new ElectricalConductance(BigDecimal::of('5000'), Microsiemens::make());
        $result = $conductance->toMillisiemens();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5')));
    }

    // ---------------------------------------------------------------
    // Round-trip conversions
    // ---------------------------------------------------------------

    public function testRoundTripSiemensToMicrosiemensAndBack(): void
    {
        $original = new ElectricalConductance(BigDecimal::of('3'), Siemens::make());
        $converted = $original->toMicrosiemens();
        $roundTrip = $converted->toSiemens();

        self::assertTrue($roundTrip->value()->isEqualTo(BigDecimal::of('3')));
    }

    public function testRoundTripMillisiemensToMicrosiemensAndBack(): void
    {
        $original = new ElectricalConductance(BigDecimal::of('250'), Millisiemens::make());
        $converted = $original->toMicrosiemens();
        $roundTrip = $converted->toMillisiemens();

        self::assertTrue($roundTrip->value()->isEqualTo(BigDecimal::of('250')));
    }

    // ---------------------------------------------------------------
    // Return type / instance checks
    // ---------------------------------------------------------------

    public function testScaleToReturnsElectricalConductanceInstance(): void
    {
        $conductance = new ElectricalConductance(BigDecimal::of('1'), Siemens::make());
        $result = $conductance->toMillisiemens();

        self::assertInstanceOf(ElectricalConductance::class, $result);
    }

    public function testConversionPreservesUnitOfMeasure(): void
    {
        $conductance = new ElectricalConductance(BigDecimal::of('1'), Siemens::make());

        self::assertInstanceOf(Millisiemens::class, $conductance->toMillisiemens()->uom());
        self::assertInstanceOf(Microsiemens::class, $conductance->toMicrosiemens()->uom());
    }

    // ---------------------------------------------------------------
    // Zero value
    // ---------------------------------------------------------------

    public function testZeroValueConversion(): void
    {
        $conductance = new ElectricalConductance(BigDecimal::of('0'), Siemens::make());
        $result = $conductance->toMillisiemens();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0')));
    }
}
