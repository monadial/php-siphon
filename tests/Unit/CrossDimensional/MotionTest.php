<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\CrossDimensional;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mass\Mass;
use Monadial\Siphon\Unit\Mass\Mass\Kilograms;
use Monadial\Siphon\Unit\Mass\MassUnit;
use Monadial\Siphon\Unit\Mechanics\Momentum;
use Monadial\Siphon\Unit\Mechanics\Momentum\KilogramMetersPerSecond;
use Monadial\Siphon\Unit\Mechanics\MomentumUnit;
use Monadial\Siphon\Unit\Mechanics\VolumeFlow;
use Monadial\Siphon\Unit\Mechanics\VolumeFlow\CubicMetersPerSecond;
use Monadial\Siphon\Unit\Mechanics\VolumeFlowUnit;
use Monadial\Siphon\Unit\Motion\Acceleration;
use Monadial\Siphon\Unit\Motion\Acceleration\MetersPerSecondSquared;
use Monadial\Siphon\Unit\Motion\AccelerationUnit;
use Monadial\Siphon\Unit\Motion\Velocity;
use Monadial\Siphon\Unit\Motion\Velocity\KilometersPerHour;
use Monadial\Siphon\Unit\Motion\Velocity\MetersPerSecond;
use Monadial\Siphon\Unit\Motion\VelocityUnit;
use Monadial\Siphon\Unit\Space\Length;
use Monadial\Siphon\Unit\Space\Length\Meters;
use Monadial\Siphon\Unit\Space\LengthUnit;
use Monadial\Siphon\Unit\Space\Volume;
use Monadial\Siphon\Unit\Space\Volume\CubicMeters;
use Monadial\Siphon\Unit\Space\VolumeUnit;
use Monadial\Siphon\Unit\Time\Time;
use Monadial\Siphon\Unit\Time\Time\Seconds;
use Monadial\Siphon\Unit\Time\TimeUnit;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Velocity::class)]
#[CoversClass(Acceleration::class)]
#[CoversClass(Length::class)]
#[CoversClass(Mass::class)]
#[CoversClass(Volume::class)]
#[CoversClass(VolumeFlow::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(VelocityUnit::class)]
#[UsesClass(AccelerationUnit::class)]
#[UsesClass(LengthUnit::class)]
#[UsesClass(MassUnit::class)]
#[UsesClass(MomentumUnit::class)]
#[UsesClass(VolumeUnit::class)]
#[UsesClass(VolumeFlowUnit::class)]
#[UsesClass(TimeUnit::class)]
#[UsesClass(MetersPerSecond::class)]
#[UsesClass(KilometersPerHour::class)]
#[UsesClass(MetersPerSecondSquared::class)]
#[UsesClass(Meters::class)]
#[UsesClass(Kilograms::class)]
#[UsesClass(KilogramMetersPerSecond::class)]
#[UsesClass(CubicMeters::class)]
#[UsesClass(CubicMetersPerSecond::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(Momentum::class)]
#[UsesClass(Time::class)]
final class MotionTest extends TestCase
{
    // ---------------------------------------------------------------
    // d = v × t (Length = Velocity × Time)
    // ---------------------------------------------------------------

    public function testVelocityTimesTimeGivesLength(): void
    {
        // 10 m/s × 60 s = 600 m
        $velocity = Velocity::metersPerSecond(10);
        $time = Time::seconds(60);
        $distance = $velocity->timesTime($time);

        self::assertInstanceOf(Length::class, $distance);
        self::assertInstanceOf(Meters::class, $distance->uom());
        self::assertEqualsWithDelta(600.0, (float) (string) $distance->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // v = d / t (Velocity = Length / Time)
    // ---------------------------------------------------------------

    public function testLengthDividedByTimeGivesVelocity(): void
    {
        // 1000 m / 10 s = 100 m/s
        $distance = Length::meters(1000);
        $time = Time::seconds(10);
        $velocity = $distance->dividedByTime($time);

        self::assertInstanceOf(Velocity::class, $velocity);
        self::assertInstanceOf(MetersPerSecond::class, $velocity->uom());
        self::assertEqualsWithDelta(100.0, (float) (string) $velocity->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // a = v / t (Acceleration = Velocity / Time)
    // ---------------------------------------------------------------

    public function testVelocityDividedByTimeGivesAcceleration(): void
    {
        // 30 m/s / 10 s = 3 m/s²
        $velocity = Velocity::metersPerSecond(30);
        $time = Time::seconds(10);
        $accel = $velocity->dividedByTime($time);

        self::assertInstanceOf(Acceleration::class, $accel);
        self::assertInstanceOf(MetersPerSecondSquared::class, $accel->uom());
        self::assertEqualsWithDelta(3.0, (float) (string) $accel->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // v = a × t (Velocity = Acceleration × Time)
    // ---------------------------------------------------------------

    public function testAccelerationTimesTimeGivesVelocity(): void
    {
        // 9.81 m/s² × 10 s = 98.1 m/s
        $accel = Acceleration::metersPerSecondSquared('9.81');
        $time = Time::seconds(10);
        $velocity = $accel->timesTime($time);

        self::assertInstanceOf(Velocity::class, $velocity);
        self::assertInstanceOf(MetersPerSecond::class, $velocity->uom());
        self::assertEqualsWithDelta(98.1, (float) (string) $velocity->value(), 0.01);
    }

    // ---------------------------------------------------------------
    // p = m × v (Momentum = Mass × Velocity)
    // ---------------------------------------------------------------

    public function testMassTimesVelocityGivesMomentum(): void
    {
        // 5 kg × 20 m/s = 100 kg⋅m/s
        $mass = Mass::kilograms(5);
        $velocity = Velocity::metersPerSecond(20);
        $momentum = $mass->timesVelocity($velocity);

        self::assertInstanceOf(Momentum::class, $momentum);
        self::assertInstanceOf(KilogramMetersPerSecond::class, $momentum->uom());
        self::assertEqualsWithDelta(100.0, (float) (string) $momentum->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // Q = V / t (VolumeFlow = Volume / Time)
    // ---------------------------------------------------------------

    public function testVolumeDividedByTimeGivesVolumeFlow(): void
    {
        // 10 m³ / 5 s = 2 m³/s
        $volume = Volume::cubicMeters(10);
        $time = Time::seconds(5);
        $flow = $volume->dividedByTime($time);

        self::assertInstanceOf(VolumeFlow::class, $flow);
        self::assertInstanceOf(CubicMetersPerSecond::class, $flow->uom());
        self::assertEqualsWithDelta(2.0, (float) (string) $flow->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // V = Q × t (Volume = VolumeFlow × Time)
    // ---------------------------------------------------------------

    public function testVolumeFlowTimesTimeGivesVolume(): void
    {
        // 0.5 m³/s × 100 s = 50 m³
        $flow = VolumeFlow::cubicMetersPerSecond('0.5');
        $time = Time::seconds(100);
        $volume = $flow->timesTime($time);

        self::assertInstanceOf(Volume::class, $volume);
        self::assertInstanceOf(CubicMeters::class, $volume->uom());
        self::assertEqualsWithDelta(50.0, (float) (string) $volume->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // Round-trip: v = a×t then a = v/t
    // ---------------------------------------------------------------

    public function testAccelerationVelocityRoundTrip(): void
    {
        $accel = Acceleration::metersPerSecondSquared('9.81');
        $time = Time::seconds(5);

        $velocity = $accel->timesTime($time); // 49.05 m/s
        $accelBack = $velocity->dividedByTime($time); // 9.81 m/s²

        self::assertEqualsWithDelta(9.81, (float) (string) $accelBack->value(), 0.001);
    }
}
