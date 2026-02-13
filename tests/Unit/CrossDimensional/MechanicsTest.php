<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\CrossDimensional;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mass\Mass;
use Monadial\Siphon\Unit\Mass\Mass\Kilograms;
use Monadial\Siphon\Unit\Mass\MassUnit;
use Monadial\Siphon\Unit\Mechanics\Density;
use Monadial\Siphon\Unit\Mechanics\Density\KilogramsPerCubicMeter;
use Monadial\Siphon\Unit\Mechanics\DensityUnit;
use Monadial\Siphon\Unit\Mechanics\Energy;
use Monadial\Siphon\Unit\Mechanics\Energy\Joules;
use Monadial\Siphon\Unit\Mechanics\EnergyUnit;
use Monadial\Siphon\Unit\Mechanics\Force;
use Monadial\Siphon\Unit\Mechanics\Force\Newtons;
use Monadial\Siphon\Unit\Mechanics\ForceUnit;
use Monadial\Siphon\Unit\Mechanics\MassFlow;
use Monadial\Siphon\Unit\Mechanics\MassFlow\KilogramsPerSecond;
use Monadial\Siphon\Unit\Mechanics\MassFlowUnit;
use Monadial\Siphon\Unit\Mechanics\Momentum;
use Monadial\Siphon\Unit\Mechanics\Momentum\KilogramMetersPerSecond;
use Monadial\Siphon\Unit\Mechanics\MomentumUnit;
use Monadial\Siphon\Unit\Mechanics\Power;
use Monadial\Siphon\Unit\Mechanics\Power\Kilowatts;
use Monadial\Siphon\Unit\Mechanics\Power\Watts;
use Monadial\Siphon\Unit\Mechanics\PowerUnit;
use Monadial\Siphon\Unit\Mechanics\Pressure;
use Monadial\Siphon\Unit\Mechanics\Pressure\Pascals;
use Monadial\Siphon\Unit\Mechanics\PressureUnit;
use Monadial\Siphon\Unit\Mechanics\Torque;
use Monadial\Siphon\Unit\Mechanics\Torque\NewtonMeters;
use Monadial\Siphon\Unit\Mechanics\TorqueUnit;
use Monadial\Siphon\Unit\Motion\Acceleration;
use Monadial\Siphon\Unit\Motion\Acceleration\MetersPerSecondSquared;
use Monadial\Siphon\Unit\Motion\AccelerationUnit;
use Monadial\Siphon\Unit\Motion\Velocity;
use Monadial\Siphon\Unit\Motion\Velocity\MetersPerSecond;
use Monadial\Siphon\Unit\Motion\VelocityUnit;
use Monadial\Siphon\Unit\Space\Area;
use Monadial\Siphon\Unit\Space\Area\SquareMeters;
use Monadial\Siphon\Unit\Space\AreaUnit;
use Monadial\Siphon\Unit\Space\Length;
use Monadial\Siphon\Unit\Space\Length\Meters;
use Monadial\Siphon\Unit\Space\LengthUnit;
use Monadial\Siphon\Unit\Space\Volume;
use Monadial\Siphon\Unit\Space\Volume\CubicMeters;
use Monadial\Siphon\Unit\Space\VolumeUnit;
use Monadial\Siphon\Unit\Time\Time;
use Monadial\Siphon\Unit\Time\Time\Hours;
use Monadial\Siphon\Unit\Time\Time\Seconds;
use Monadial\Siphon\Unit\Time\TimeUnit;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Mass::class)]
#[CoversClass(Force::class)]
#[CoversClass(Energy::class)]
#[CoversClass(Power::class)]
#[CoversClass(Pressure::class)]
#[CoversClass(Density::class)]
#[CoversClass(MassFlow::class)]
#[CoversClass(Momentum::class)]
#[CoversClass(Torque::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(MassUnit::class)]
#[UsesClass(ForceUnit::class)]
#[UsesClass(EnergyUnit::class)]
#[UsesClass(PowerUnit::class)]
#[UsesClass(PressureUnit::class)]
#[UsesClass(DensityUnit::class)]
#[UsesClass(MassFlowUnit::class)]
#[UsesClass(MomentumUnit::class)]
#[UsesClass(TorqueUnit::class)]
#[UsesClass(AccelerationUnit::class)]
#[UsesClass(VelocityUnit::class)]
#[UsesClass(LengthUnit::class)]
#[UsesClass(AreaUnit::class)]
#[UsesClass(VolumeUnit::class)]
#[UsesClass(TimeUnit::class)]
#[UsesClass(Kilograms::class)]
#[UsesClass(Newtons::class)]
#[UsesClass(Joules::class)]
#[UsesClass(Watts::class)]
#[UsesClass(Kilowatts::class)]
#[UsesClass(Pascals::class)]
#[UsesClass(KilogramsPerCubicMeter::class)]
#[UsesClass(KilogramsPerSecond::class)]
#[UsesClass(KilogramMetersPerSecond::class)]
#[UsesClass(NewtonMeters::class)]
#[UsesClass(MetersPerSecondSquared::class)]
#[UsesClass(MetersPerSecond::class)]
#[UsesClass(Meters::class)]
#[UsesClass(SquareMeters::class)]
#[UsesClass(CubicMeters::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(Hours::class)]
#[UsesClass(Acceleration::class)]
#[UsesClass(Velocity::class)]
#[UsesClass(Length::class)]
#[UsesClass(Momentum::class)]
#[UsesClass(Torque::class)]
#[UsesClass(Area::class)]
#[UsesClass(Volume::class)]
#[UsesClass(Time::class)]
final class MechanicsTest extends TestCase
{
    // ---------------------------------------------------------------
    // F = m × a
    // ---------------------------------------------------------------

    public function testMassTimesAccelerationGivesForce(): void
    {
        // 10 kg × 9.81 m/s² = 98.1 N
        $mass = Mass::kilograms(10);
        $accel = Acceleration::metersPerSecondSquared('9.81');
        $force = $mass->timesAcceleration($accel);

        self::assertInstanceOf(Force::class, $force);
        self::assertInstanceOf(Newtons::class, $force->uom());
        self::assertEqualsWithDelta(98.1, (float) (string) $force->value(), 0.01);
    }

    // ---------------------------------------------------------------
    // W = F × d (Energy = Force × Length)
    // ---------------------------------------------------------------

    public function testForceTimesLengthGivesEnergy(): void
    {
        // 100 N × 5 m = 500 J
        $force = Force::newtons(100);
        $distance = Length::meters(5);
        $energy = $force->timesLength($distance);

        self::assertInstanceOf(Energy::class, $energy);
        self::assertInstanceOf(Joules::class, $energy->uom());
        self::assertEqualsWithDelta(500.0, (float) (string) $energy->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // P = E / t
    // ---------------------------------------------------------------

    public function testEnergyDividedByTimeGivesPower(): void
    {
        // 3600 J / 1 s = 3600 W
        $energy = Energy::joules(3600);
        $time = Time::seconds(1);
        $power = $energy->dividedByTime($time);

        self::assertInstanceOf(Power::class, $power);
        self::assertInstanceOf(Watts::class, $power->uom());
        self::assertEqualsWithDelta(3600.0, (float) (string) $power->value(), 0.01);
    }

    public function testEnergyDividedByTimeWithHours(): void
    {
        // 3600 J / 1 h = 3600 J / 3600 s = 1 W
        $energy = Energy::joules(3600);
        $time = Time::hours(1);
        $power = $energy->dividedByTime($time);

        self::assertEqualsWithDelta(1.0, (float) (string) $power->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // E = P × t
    // ---------------------------------------------------------------

    public function testPowerTimesTimeGivesEnergy(): void
    {
        // 1000 W × 3600 s = 3600000 J
        $power = Power::watts(1000);
        $time = Time::seconds(3600);
        $energy = $power->timesTime($time);

        self::assertInstanceOf(Energy::class, $energy);
        self::assertInstanceOf(Joules::class, $energy->uom());
        self::assertEqualsWithDelta(3600000.0, (float) (string) $energy->value(), 0.01);
    }

    // ---------------------------------------------------------------
    // t = E / P
    // ---------------------------------------------------------------

    public function testEnergyDividedByPowerGivesTime(): void
    {
        // 7200 J / 100 W = 72 s
        $energy = Energy::joules(7200);
        $power = Power::watts(100);
        $time = $energy->dividedByPower($power);

        self::assertInstanceOf(Time::class, $time);
        self::assertInstanceOf(Seconds::class, $time->uom());
        self::assertEqualsWithDelta(72.0, (float) (string) $time->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // P = F × v
    // ---------------------------------------------------------------

    public function testForceTimesVelocityGivesPower(): void
    {
        // 50 N × 10 m/s = 500 W
        $force = Force::newtons(50);
        $velocity = Velocity::metersPerSecond(10);
        $power = $force->timesVelocity($velocity);

        self::assertInstanceOf(Power::class, $power);
        self::assertInstanceOf(Watts::class, $power->uom());
        self::assertEqualsWithDelta(500.0, (float) (string) $power->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // P = F / A (Pressure = Force / Area)
    // ---------------------------------------------------------------

    public function testForceDividedByAreaGivesPressure(): void
    {
        // 1000 N / 2 m² = 500 Pa
        $force = Force::newtons(1000);
        $area = Area::squareMeters(2);
        $pressure = $force->dividedByArea($area);

        self::assertInstanceOf(Pressure::class, $pressure);
        self::assertInstanceOf(Pascals::class, $pressure->uom());
        self::assertEqualsWithDelta(500.0, (float) (string) $pressure->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // F = P × A (Force = Pressure × Area)
    // ---------------------------------------------------------------

    public function testPressureTimesAreaGivesForce(): void
    {
        // 101325 Pa × 1 m² = 101325 N
        $pressure = Pressure::pascals(101325);
        $area = Area::squareMeters(1);
        $force = $pressure->timesArea($area);

        self::assertInstanceOf(Force::class, $force);
        self::assertInstanceOf(Newtons::class, $force->uom());
        self::assertEqualsWithDelta(101325.0, (float) (string) $force->value(), 0.01);
    }

    // ---------------------------------------------------------------
    // ρ = m / V (Density = Mass / Volume)
    // ---------------------------------------------------------------

    public function testMassDividedByVolumeGivesDensity(): void
    {
        // 1000 kg / 1 m³ = 1000 kg/m³
        $mass = Mass::kilograms(1000);
        $volume = Volume::cubicMeters(1);
        $density = $mass->dividedByVolume($volume);

        self::assertInstanceOf(Density::class, $density);
        self::assertInstanceOf(KilogramsPerCubicMeter::class, $density->uom());
        self::assertEqualsWithDelta(1000.0, (float) (string) $density->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // m = ρ × V
    // ---------------------------------------------------------------

    public function testDensityTimesVolumeGivesMass(): void
    {
        // 1000 kg/m³ × 0.5 m³ = 500 kg
        $density = Density::kilogramsPerCubicMeter(1000);
        $volume = Volume::cubicMeters('0.5');
        $mass = $density->timesVolume($volume);

        self::assertInstanceOf(Mass::class, $mass);
        self::assertInstanceOf(Kilograms::class, $mass->uom());
        self::assertEqualsWithDelta(500.0, (float) (string) $mass->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // ṁ = m / t (Mass flow)
    // ---------------------------------------------------------------

    public function testMassDividedByTimeGivesMassFlow(): void
    {
        // 100 kg / 10 s = 10 kg/s
        $mass = Mass::kilograms(100);
        $time = Time::seconds(10);
        $flow = $mass->dividedByTime($time);

        self::assertInstanceOf(MassFlow::class, $flow);
        self::assertInstanceOf(KilogramsPerSecond::class, $flow->uom());
        self::assertEqualsWithDelta(10.0, (float) (string) $flow->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // m = ṁ × t
    // ---------------------------------------------------------------

    public function testMassFlowTimesTimeGivesMass(): void
    {
        // 5 kg/s × 60 s = 300 kg
        $flow = MassFlow::kilogramsPerSecond(5);
        $time = Time::seconds(60);
        $mass = $flow->timesTime($time);

        self::assertInstanceOf(Mass::class, $mass);
        self::assertInstanceOf(Kilograms::class, $mass->uom());
        self::assertEqualsWithDelta(300.0, (float) (string) $mass->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // Round-trip: F = m×a, E = F×d, P = E/t
    // ---------------------------------------------------------------

    public function testNewtonianChain(): void
    {
        // m=10kg, a=9.81m/s², d=100m, t=10s
        $mass = Mass::kilograms(10);
        $accel = Acceleration::metersPerSecondSquared('9.81');
        $distance = Length::meters(100);
        $time = Time::seconds(10);

        $force = $mass->timesAcceleration($accel); // 98.1 N
        $energy = $force->timesLength($distance); // 9810 J
        $power = $energy->dividedByTime($time); // 981 W

        self::assertEqualsWithDelta(98.1, (float) (string) $force->value(), 0.01);
        self::assertEqualsWithDelta(9810.0, (float) (string) $energy->value(), 0.1);
        self::assertEqualsWithDelta(981.0, (float) (string) $power->value(), 0.1);
    }

    // ---------------------------------------------------------------
    // a = F / m (Force / Mass = Acceleration)
    // ---------------------------------------------------------------

    public function testForceDividedByMassGivesAcceleration(): void
    {
        // 100 N / 10 kg = 10 m/s²
        $force = Force::newtons(100);
        $mass = Mass::kilograms(10);
        $accel = $force->dividedByMass($mass);

        self::assertInstanceOf(Acceleration::class, $accel);
        self::assertInstanceOf(MetersPerSecondSquared::class, $accel->uom());
        self::assertEqualsWithDelta(10.0, (float) (string) $accel->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // m = F / a (Force / Acceleration = Mass)
    // ---------------------------------------------------------------

    public function testForceDividedByAccelerationGivesMass(): void
    {
        // 98.1 N / 9.81 m/s² = 10 kg
        $force = Force::newtons('98.1');
        $accel = Acceleration::metersPerSecondSquared('9.81');
        $mass = $force->dividedByAcceleration($accel);

        self::assertInstanceOf(Mass::class, $mass);
        self::assertInstanceOf(Kilograms::class, $mass->uom());
        self::assertEqualsWithDelta(10.0, (float) (string) $mass->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // F = W / d (Energy / Length = Force)
    // ---------------------------------------------------------------

    public function testEnergyDividedByLengthGivesForce(): void
    {
        // 500 J / 5 m = 100 N
        $energy = Energy::joules(500);
        $distance = Length::meters(5);
        $force = $energy->dividedByLength($distance);

        self::assertInstanceOf(Force::class, $force);
        self::assertInstanceOf(Newtons::class, $force->uom());
        self::assertEqualsWithDelta(100.0, (float) (string) $force->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // d = W / F (Energy / Force = Length)
    // ---------------------------------------------------------------

    public function testEnergyDividedByForceGivesLength(): void
    {
        // 500 J / 100 N = 5 m
        $energy = Energy::joules(500);
        $force = Force::newtons(100);
        $distance = $energy->dividedByForce($force);

        self::assertInstanceOf(Length::class, $distance);
        self::assertInstanceOf(Meters::class, $distance->uom());
        self::assertEqualsWithDelta(5.0, (float) (string) $distance->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // P = E / V (Energy / Volume = Pressure)
    // ---------------------------------------------------------------

    public function testEnergyDividedByVolumeGivesPressure(): void
    {
        // 101325 J / 1 m³ = 101325 Pa
        $energy = Energy::joules(101325);
        $volume = Volume::cubicMeters(1);
        $pressure = $energy->dividedByVolume($volume);

        self::assertInstanceOf(Pressure::class, $pressure);
        self::assertInstanceOf(Pascals::class, $pressure->uom());
        self::assertEqualsWithDelta(101325.0, (float) (string) $pressure->value(), 0.01);
    }

    // ---------------------------------------------------------------
    // v = P / F (Power / Force = Velocity)
    // ---------------------------------------------------------------

    public function testPowerDividedByForceGivesVelocity(): void
    {
        // 500 W / 50 N = 10 m/s
        $power = Power::watts(500);
        $force = Force::newtons(50);
        $velocity = $power->dividedByForce($force);

        self::assertInstanceOf(Velocity::class, $velocity);
        self::assertInstanceOf(MetersPerSecond::class, $velocity->uom());
        self::assertEqualsWithDelta(10.0, (float) (string) $velocity->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // F = P / v (Power / Velocity = Force)
    // ---------------------------------------------------------------

    public function testPowerDividedByVelocityGivesForce(): void
    {
        // 500 W / 10 m/s = 50 N
        $power = Power::watts(500);
        $velocity = Velocity::metersPerSecond(10);
        $force = $power->dividedByVelocity($velocity);

        self::assertInstanceOf(Force::class, $force);
        self::assertInstanceOf(Newtons::class, $force->uom());
        self::assertEqualsWithDelta(50.0, (float) (string) $force->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // E = P × V (Pressure × Volume = Energy)
    // ---------------------------------------------------------------

    public function testPressureTimesVolumeGivesEnergy(): void
    {
        // 101325 Pa × 1 m³ = 101325 J
        $pressure = Pressure::pascals(101325);
        $volume = Volume::cubicMeters(1);
        $energy = $pressure->timesVolume($volume);

        self::assertInstanceOf(Energy::class, $energy);
        self::assertInstanceOf(Joules::class, $energy->uom());
        self::assertEqualsWithDelta(101325.0, (float) (string) $energy->value(), 0.01);
    }

    // ---------------------------------------------------------------
    // v = p / m (Momentum / Mass = Velocity)
    // ---------------------------------------------------------------

    public function testMomentumDividedByMassGivesVelocity(): void
    {
        // 100 kg⋅m/s / 5 kg = 20 m/s
        $momentum = Momentum::kilogramMetersPerSecond(100);
        $mass = Mass::kilograms(5);
        $velocity = $momentum->dividedByMass($mass);

        self::assertInstanceOf(Velocity::class, $velocity);
        self::assertInstanceOf(MetersPerSecond::class, $velocity->uom());
        self::assertEqualsWithDelta(20.0, (float) (string) $velocity->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // m = p / v (Momentum / Velocity = Mass)
    // ---------------------------------------------------------------

    public function testMomentumDividedByVelocityGivesMass(): void
    {
        // 100 kg⋅m/s / 20 m/s = 5 kg
        $momentum = Momentum::kilogramMetersPerSecond(100);
        $velocity = Velocity::metersPerSecond(20);
        $mass = $momentum->dividedByVelocity($velocity);

        self::assertInstanceOf(Mass::class, $mass);
        self::assertInstanceOf(Kilograms::class, $mass->uom());
        self::assertEqualsWithDelta(5.0, (float) (string) $mass->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // F = Δp / Δt (Momentum / Time = Force)
    // ---------------------------------------------------------------

    public function testMomentumDividedByTimeGivesForce(): void
    {
        // 100 kg⋅m/s / 10 s = 10 N
        $momentum = Momentum::kilogramMetersPerSecond(100);
        $time = Time::seconds(10);
        $force = $momentum->dividedByTime($time);

        self::assertInstanceOf(Force::class, $force);
        self::assertInstanceOf(Newtons::class, $force->uom());
        self::assertEqualsWithDelta(10.0, (float) (string) $force->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // d = τ / F (Torque / Force = Length)
    // ---------------------------------------------------------------

    public function testTorqueDividedByForceGivesLength(): void
    {
        // 50 N⋅m / 10 N = 5 m
        $torque = Torque::newtonMeters(50);
        $force = Force::newtons(10);
        $length = $torque->dividedByForce($force);

        self::assertInstanceOf(Length::class, $length);
        self::assertInstanceOf(Meters::class, $length->uom());
        self::assertEqualsWithDelta(5.0, (float) (string) $length->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // F = τ / d (Torque / Length = Force)
    // ---------------------------------------------------------------

    public function testTorqueDividedByLengthGivesForce(): void
    {
        // 50 N⋅m / 5 m = 10 N
        $torque = Torque::newtonMeters(50);
        $length = Length::meters(5);
        $force = $torque->dividedByLength($length);

        self::assertInstanceOf(Force::class, $force);
        self::assertInstanceOf(Newtons::class, $force->uom());
        self::assertEqualsWithDelta(10.0, (float) (string) $force->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // V = m / ρ (Mass / Density = Volume)
    // ---------------------------------------------------------------

    public function testMassDividedByDensityGivesVolume(): void
    {
        // 1000 kg / 1000 kg/m³ = 1 m³
        $mass = Mass::kilograms(1000);
        $density = Density::kilogramsPerCubicMeter(1000);
        $volume = $mass->dividedByDensity($density);

        self::assertInstanceOf(Volume::class, $volume);
        self::assertInstanceOf(CubicMeters::class, $volume->uom());
        self::assertEqualsWithDelta(1.0, (float) (string) $volume->value(), 0.0001);
    }
}
