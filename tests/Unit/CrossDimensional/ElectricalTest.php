<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\CrossDimensional;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\Capacitance;
use Monadial\Siphon\Unit\Electrical\Capacitance\Farads;
use Monadial\Siphon\Unit\Electrical\CapacitanceUnit;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance\Ohms;
use Monadial\Siphon\Unit\Electrical\ElectricalResistanceUnit;
use Monadial\Siphon\Unit\Electrical\ElectricCharge;
use Monadial\Siphon\Unit\Electrical\ElectricCharge\Coulombs;
use Monadial\Siphon\Unit\Electrical\ElectricChargeUnit;
use Monadial\Siphon\Unit\Electrical\ElectricCurrent;
use Monadial\Siphon\Unit\Electrical\ElectricCurrent\Amperes;
use Monadial\Siphon\Unit\Electrical\ElectricCurrentUnit;
use Monadial\Siphon\Unit\Electrical\ElectricPotential;
use Monadial\Siphon\Unit\Electrical\ElectricPotential\Volts;
use Monadial\Siphon\Unit\Electrical\ElectricPotentialUnit;
use Monadial\Siphon\Unit\Mechanics\Power;
use Monadial\Siphon\Unit\Mechanics\Power\Watts;
use Monadial\Siphon\Unit\Mechanics\PowerUnit;
use Monadial\Siphon\Unit\Time\Time;
use Monadial\Siphon\Unit\Time\Time\Seconds;
use Monadial\Siphon\Unit\Time\TimeUnit;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ElectricPotential::class)]
#[CoversClass(ElectricCurrent::class)]
#[CoversClass(ElectricalResistance::class)]
#[CoversClass(ElectricCharge::class)]
#[CoversClass(Capacitance::class)]
#[CoversClass(Power::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(ElectricPotentialUnit::class)]
#[UsesClass(ElectricCurrentUnit::class)]
#[UsesClass(ElectricalResistanceUnit::class)]
#[UsesClass(ElectricChargeUnit::class)]
#[UsesClass(PowerUnit::class)]
#[UsesClass(TimeUnit::class)]
#[UsesClass(Volts::class)]
#[UsesClass(Amperes::class)]
#[UsesClass(Ohms::class)]
#[UsesClass(Coulombs::class)]
#[UsesClass(Watts::class)]
#[UsesClass(Farads::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(CapacitanceUnit::class)]
#[UsesClass(Time::class)]
final class ElectricalTest extends TestCase
{
    // ---------------------------------------------------------------
    // P = V × I (Power = Voltage × Current)
    // ---------------------------------------------------------------

    public function testVoltageTimesCurrentGivesPower(): void
    {
        // 230V × 10A = 2300W
        $voltage = ElectricPotential::volts(230);
        $current = ElectricCurrent::amperes(10);
        $power = $voltage->timesCurrent($current);

        self::assertInstanceOf(Power::class, $power);
        self::assertInstanceOf(Watts::class, $power->uom());
        self::assertEqualsWithDelta(2300.0, (float) (string) $power->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // V = I × R (Ohm's law)
    // ---------------------------------------------------------------

    public function testCurrentTimesResistanceGivesVoltage(): void
    {
        // 5A × 100Ω = 500V
        $current = ElectricCurrent::amperes(5);
        $resistance = ElectricalResistance::ohms(100);
        $voltage = $current->timesResistance($resistance);

        self::assertInstanceOf(ElectricPotential::class, $voltage);
        self::assertInstanceOf(Volts::class, $voltage->uom());
        self::assertEqualsWithDelta(500.0, (float) (string) $voltage->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // Q = I × t (Charge = Current × Time)
    // ---------------------------------------------------------------

    public function testCurrentTimesTimeGivesCharge(): void
    {
        // 2A × 3600s = 7200C
        $current = ElectricCurrent::amperes(2);
        $time = Time::seconds(3600);
        $charge = $current->timesTime($time);

        self::assertInstanceOf(ElectricCharge::class, $charge);
        self::assertInstanceOf(Coulombs::class, $charge->uom());
        self::assertEqualsWithDelta(7200.0, (float) (string) $charge->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // P = I² × R (via chain: V = I×R, P = V×I)
    // ---------------------------------------------------------------

    public function testPowerFromCurrentAndResistance(): void
    {
        // I=3A, R=10Ω → V=30V → P=30V×3A=90W
        $current = ElectricCurrent::amperes(3);
        $resistance = ElectricalResistance::ohms(10);

        $voltage = $current->timesResistance($resistance);
        $power = $voltage->timesCurrent($current);

        self::assertEqualsWithDelta(90.0, (float) (string) $power->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // V = P / I (Power / Current = Voltage)
    // ---------------------------------------------------------------

    public function testPowerDividedByCurrentGivesVoltage(): void
    {
        // 2300 W / 10 A = 230 V
        $power = Power::watts(2300);
        $current = ElectricCurrent::amperes(10);
        $voltage = $power->dividedByCurrent($current);

        self::assertInstanceOf(ElectricPotential::class, $voltage);
        self::assertInstanceOf(Volts::class, $voltage->uom());
        self::assertEqualsWithDelta(230.0, (float) (string) $voltage->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // I = P / V (Power / Voltage = Current)
    // ---------------------------------------------------------------

    public function testPowerDividedByPotentialGivesCurrent(): void
    {
        // 2300 W / 230 V = 10 A
        $power = Power::watts(2300);
        $voltage = ElectricPotential::volts(230);
        $current = $power->dividedByPotential($voltage);

        self::assertInstanceOf(ElectricCurrent::class, $current);
        self::assertInstanceOf(Amperes::class, $current->uom());
        self::assertEqualsWithDelta(10.0, (float) (string) $current->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // R = V / I (Ohm's law)
    // ---------------------------------------------------------------

    public function testVoltageDividedByCurrentGivesResistance(): void
    {
        // 500 V / 5 A = 100 Ω
        $voltage = ElectricPotential::volts(500);
        $current = ElectricCurrent::amperes(5);
        $resistance = $voltage->dividedByCurrent($current);

        self::assertInstanceOf(ElectricalResistance::class, $resistance);
        self::assertInstanceOf(Ohms::class, $resistance->uom());
        self::assertEqualsWithDelta(100.0, (float) (string) $resistance->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // I = V / R (Ohm's law)
    // ---------------------------------------------------------------

    public function testVoltageDividedByResistanceGivesCurrent(): void
    {
        // 500 V / 100 Ω = 5 A
        $voltage = ElectricPotential::volts(500);
        $resistance = ElectricalResistance::ohms(100);
        $current = $voltage->dividedByResistance($resistance);

        self::assertInstanceOf(ElectricCurrent::class, $current);
        self::assertInstanceOf(Amperes::class, $current->uom());
        self::assertEqualsWithDelta(5.0, (float) (string) $current->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // V = I × R (Resistance × Current = Voltage)
    // ---------------------------------------------------------------

    public function testResistanceTimesCurrentGivesVoltage(): void
    {
        // 100 Ω × 5 A = 500 V
        $resistance = ElectricalResistance::ohms(100);
        $current = ElectricCurrent::amperes(5);
        $voltage = $resistance->timesCurrent($current);

        self::assertInstanceOf(ElectricPotential::class, $voltage);
        self::assertInstanceOf(Volts::class, $voltage->uom());
        self::assertEqualsWithDelta(500.0, (float) (string) $voltage->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // I = Q / t (Charge / Time = Current)
    // ---------------------------------------------------------------

    public function testChargeDividedByTimeGivesCurrent(): void
    {
        // 7200 C / 3600 s = 2 A
        $charge = ElectricCharge::coulombs(7200);
        $time = Time::seconds(3600);
        $current = $charge->dividedByTime($time);

        self::assertInstanceOf(ElectricCurrent::class, $current);
        self::assertInstanceOf(Amperes::class, $current->uom());
        self::assertEqualsWithDelta(2.0, (float) (string) $current->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // t = Q / I (Charge / Current = Time)
    // ---------------------------------------------------------------

    public function testChargeDividedByCurrentGivesTime(): void
    {
        // 7200 C / 2 A = 3600 s
        $charge = ElectricCharge::coulombs(7200);
        $current = ElectricCurrent::amperes(2);
        $time = $charge->dividedByCurrent($current);

        self::assertInstanceOf(Time::class, $time);
        self::assertInstanceOf(Seconds::class, $time->uom());
        self::assertEqualsWithDelta(3600.0, (float) (string) $time->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // V = Q / C (Charge / Capacitance = Voltage)
    // ---------------------------------------------------------------

    public function testChargeDividedByCapacitanceGivesVoltage(): void
    {
        // 10 C / 0.5 F = 20 V
        $charge = ElectricCharge::coulombs(10);
        $capacitance = Capacitance::farads('0.5');
        $voltage = $charge->dividedByCapacitance($capacitance);

        self::assertInstanceOf(ElectricPotential::class, $voltage);
        self::assertInstanceOf(Volts::class, $voltage->uom());
        self::assertEqualsWithDelta(20.0, (float) (string) $voltage->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // Q = C × V (Capacitance × Voltage = Charge)
    // ---------------------------------------------------------------

    public function testCapacitanceTimesPotentialGivesCharge(): void
    {
        // 0.5 F × 20 V = 10 C
        $capacitance = Capacitance::farads('0.5');
        $voltage = ElectricPotential::volts(20);
        $charge = $capacitance->timesPotential($voltage);

        self::assertInstanceOf(ElectricCharge::class, $charge);
        self::assertInstanceOf(Coulombs::class, $charge->uom());
        self::assertEqualsWithDelta(10.0, (float) (string) $charge->value(), 0.0001);
    }
}
