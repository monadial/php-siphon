<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Electrical;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricPotential;
use Monadial\Siphon\Unit\Electrical\ElectricPotential\Kilovolts;
use Monadial\Siphon\Unit\Electrical\ElectricPotential\Megavolts;
use Monadial\Siphon\Unit\Electrical\ElectricPotential\Microvolts;
use Monadial\Siphon\Unit\Electrical\ElectricPotential\Millivolts;
use Monadial\Siphon\Unit\Electrical\ElectricPotential\Volts;
use Monadial\Siphon\Unit\Electrical\ElectricPotentialUnit;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ElectricPotential::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(Volts::class)]
#[UsesClass(Microvolts::class)]
#[UsesClass(Millivolts::class)]
#[UsesClass(Kilovolts::class)]
#[UsesClass(Megavolts::class)]
#[UsesClass(ElectricPotentialUnit::class)]
final class ElectricPotentialTest extends TestCase
{
    // ---------------------------------------------------------------
    // Construction and basic accessors
    // ---------------------------------------------------------------

    public function testConstructionAndValueAccess(): void
    {
        $potential = new ElectricPotential(BigDecimal::of('230'), Volts::make());

        self::assertTrue($potential->value()->isEqualTo(BigDecimal::of('230')));
        self::assertInstanceOf(Volts::class, $potential->uom());
    }

    // ---------------------------------------------------------------
    // Identity conversions
    // ---------------------------------------------------------------

    public function testIdentityConversion(): void
    {
        $potential = new ElectricPotential(BigDecimal::of('5'), Volts::make());
        $result = $potential->toVolts();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5')));
    }

    // ---------------------------------------------------------------
    // Volts to other units
    // ---------------------------------------------------------------

    public function testVoltsToMillivolts(): void
    {
        $potential = new ElectricPotential(BigDecimal::of('1'), Volts::make());
        $result = $potential->toMillivolts();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testVoltsToMicrovolts(): void
    {
        $potential = new ElectricPotential(BigDecimal::of('1'), Volts::make());
        $result = $potential->toMicrovolts();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    public function testVoltsToKilovolts(): void
    {
        $potential = new ElectricPotential(BigDecimal::of('1000'), Volts::make());
        $result = $potential->toKilovolts();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testVoltsToMegavolts(): void
    {
        $potential = new ElectricPotential(BigDecimal::of('1000000'), Volts::make());
        $result = $potential->toMegavolts();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    // ---------------------------------------------------------------
    // Other units to volts
    // ---------------------------------------------------------------

    public function testMillivoltsToVolts(): void
    {
        $potential = new ElectricPotential(BigDecimal::of('500'), Millivolts::make());
        $result = $potential->toVolts();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.5')));
    }

    public function testMicrovoltsToVolts(): void
    {
        $potential = new ElectricPotential(BigDecimal::of('1000000'), Microvolts::make());
        $result = $potential->toVolts();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testKilovoltsToVolts(): void
    {
        $potential = new ElectricPotential(BigDecimal::of('1'), Kilovolts::make());
        $result = $potential->toVolts();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testMegavoltsToVolts(): void
    {
        $potential = new ElectricPotential(BigDecimal::of('1'), Megavolts::make());
        $result = $potential->toVolts();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    // ---------------------------------------------------------------
    // Cross-conversions
    // ---------------------------------------------------------------

    public function testKilovoltsToMillivolts(): void
    {
        $potential = new ElectricPotential(BigDecimal::of('1'), Kilovolts::make());
        $result = $potential->toMillivolts();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    public function testMicrovoltsToKilovolts(): void
    {
        $potential = new ElectricPotential(BigDecimal::of('1000000000'), Microvolts::make());
        $result = $potential->toKilovolts();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    // ---------------------------------------------------------------
    // Round-trip conversions
    // ---------------------------------------------------------------

    public function testRoundTripVoltsToMegavoltsAndBack(): void
    {
        $original = new ElectricPotential(BigDecimal::of('5000000'), Volts::make());
        $converted = $original->toMegavolts();
        $roundTrip = $converted->toVolts();

        self::assertTrue($roundTrip->value()->isEqualTo(BigDecimal::of('5000000')));
    }

    public function testRoundTripMillivoltsToMicrovoltsAndBack(): void
    {
        $original = new ElectricPotential(BigDecimal::of('250'), Millivolts::make());
        $converted = $original->toMicrovolts();
        $roundTrip = $converted->toMillivolts();

        self::assertTrue($roundTrip->value()->isEqualTo(BigDecimal::of('250')));
    }

    // ---------------------------------------------------------------
    // Return type / instance checks
    // ---------------------------------------------------------------

    public function testScaleToReturnsElectricPotentialInstance(): void
    {
        $potential = new ElectricPotential(BigDecimal::of('1'), Volts::make());
        $result = $potential->toKilovolts();

        self::assertInstanceOf(ElectricPotential::class, $result);
    }

    public function testConversionPreservesUnitOfMeasure(): void
    {
        $potential = new ElectricPotential(BigDecimal::of('1'), Volts::make());

        self::assertInstanceOf(Microvolts::class, $potential->toMicrovolts()->uom());
        self::assertInstanceOf(Millivolts::class, $potential->toMillivolts()->uom());
        self::assertInstanceOf(Kilovolts::class, $potential->toKilovolts()->uom());
        self::assertInstanceOf(Megavolts::class, $potential->toMegavolts()->uom());
    }

    // ---------------------------------------------------------------
    // Zero value
    // ---------------------------------------------------------------

    public function testZeroValueConversion(): void
    {
        $potential = new ElectricPotential(BigDecimal::of('0'), Volts::make());
        $result = $potential->toKilovolts();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0')));
    }
}
