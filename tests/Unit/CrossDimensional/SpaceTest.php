<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\CrossDimensional;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\VolumeFlow;
use Monadial\Siphon\Unit\Mechanics\VolumeFlow\CubicMetersPerSecond;
use Monadial\Siphon\Unit\Mechanics\VolumeFlowUnit;
use Monadial\Siphon\Unit\Space\Area;
use Monadial\Siphon\Unit\Space\Area\SquareMeters;
use Monadial\Siphon\Unit\Space\AreaUnit;
use Monadial\Siphon\Unit\Space\Length;
use Monadial\Siphon\Unit\Space\Length\Kilometers;
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

#[CoversClass(Length::class)]
#[CoversClass(Area::class)]
#[CoversClass(Volume::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(LengthUnit::class)]
#[UsesClass(AreaUnit::class)]
#[UsesClass(VolumeUnit::class)]
#[UsesClass(Meters::class)]
#[UsesClass(Kilometers::class)]
#[UsesClass(SquareMeters::class)]
#[UsesClass(CubicMeters::class)]
#[UsesClass(CubicMetersPerSecond::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(Volume::class)]
#[UsesClass(VolumeFlow::class)]
#[UsesClass(VolumeFlowUnit::class)]
#[UsesClass(TimeUnit::class)]
#[UsesClass(Time::class)]
final class SpaceTest extends TestCase
{
    public function testLengthTimesLengthGivesArea(): void
    {
        $a = Length::meters(5);
        $b = Length::meters(4);
        $result = $a->timesLength($b);

        self::assertInstanceOf(Area::class, $result);
        self::assertInstanceOf(SquareMeters::class, $result->uom());
        self::assertEqualsWithDelta(20.0, (float) (string) $result->value(), 0.0001);
    }

    public function testLengthTimesLengthCrossUnit(): void
    {
        $a = Length::kilometers(1); // 1000 m
        $b = Length::meters(500);
        $result = $a->timesLength($b);

        // 1000 * 500 = 500000 m²
        self::assertEqualsWithDelta(500000.0, (float) (string) $result->value(), 0.01);
    }

    public function testLengthTimesAreaGivesVolume(): void
    {
        $length = Length::meters(3);
        $area = Area::squareMeters(10);
        $result = $length->timesArea($area);

        self::assertInstanceOf(Volume::class, $result);
        self::assertInstanceOf(CubicMeters::class, $result->uom());
        self::assertEqualsWithDelta(30.0, (float) (string) $result->value(), 0.0001);
    }

    public function testAreaTimesLengthGivesVolume(): void
    {
        $area = Area::squareMeters(10);
        $length = Length::meters(5);
        $result = $area->timesLength($length);

        self::assertInstanceOf(Volume::class, $result);
        self::assertInstanceOf(CubicMeters::class, $result->uom());
        self::assertEqualsWithDelta(50.0, (float) (string) $result->value(), 0.0001);
    }

    public function testLengthTimesLengthTimesLengthGivesVolume(): void
    {
        $a = Length::meters(2);
        $b = Length::meters(3);
        $c = Length::meters(4);

        $area = $a->timesLength($b);
        $volume = $area->timesLength($c);

        self::assertInstanceOf(Volume::class, $volume);
        self::assertEqualsWithDelta(24.0, (float) (string) $volume->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // t = V / Q̇ (Volume / VolumeFlow = Time)
    // ---------------------------------------------------------------

    public function testVolumeDividedByVolumeFlowGivesTime(): void
    {
        // 10 m³ / 2 m³/s = 5 s
        $volume = Volume::cubicMeters(10);
        $flow = VolumeFlow::cubicMetersPerSecond(2);
        $time = $volume->dividedByVolumeFlow($flow);

        self::assertInstanceOf(Time::class, $time);
        self::assertInstanceOf(Seconds::class, $time->uom());
        self::assertEqualsWithDelta(5.0, (float) (string) $time->value(), 0.0001);
    }
}
