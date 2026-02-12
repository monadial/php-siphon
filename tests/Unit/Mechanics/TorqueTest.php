<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Mechanics;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\Torque;
use Monadial\Siphon\Unit\Mechanics\Torque\NewtonMeters;
use Monadial\Siphon\Unit\Mechanics\Torque\PoundFeet;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Torque::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(NewtonMeters::class)]
#[UsesClass(PoundFeet::class)]
final class TorqueTest extends TestCase
{
    public function testIdentityConversion(): void
    {
        $torque = new Torque(BigDecimal::of('100'), NewtonMeters::make());
        $result = $torque->toNewtonMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('100')));
    }

    public function testNewtonMetersToPoundFeet(): void
    {
        // 1 N·m ≈ 0.7376 lb·ft
        $torque = new Torque(BigDecimal::of('1'), NewtonMeters::make());
        $result = $torque->toPoundFeet();

        self::assertEqualsWithDelta(0.7376, (float) (string) $result->value(), 0.001);
    }

    public function testPoundFeetToNewtonMeters(): void
    {
        // 1 lb·ft = 1.3558179483314004 N·m
        $torque = new Torque(BigDecimal::of('1'), PoundFeet::make());
        $result = $torque->toNewtonMeters();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1.3558179483314004')));
    }

    public function testRoundTripNewtonMetersToPoundFeetAndBack(): void
    {
        $original = new Torque(BigDecimal::of('50'), NewtonMeters::make());
        $converted = $original->toPoundFeet();
        $roundTrip = $converted->toNewtonMeters();

        self::assertEqualsWithDelta(50.0, (float) (string) $roundTrip->value(), 0.0001);
    }

    public function testEngineTorque(): void
    {
        // Typical engine: 300 N·m ≈ 221.3 lb·ft
        $torque = new Torque(BigDecimal::of('300'), NewtonMeters::make());
        $result = $torque->toPoundFeet();

        self::assertEqualsWithDelta(221.3, (float) (string) $result->value(), 0.1);
    }
}
