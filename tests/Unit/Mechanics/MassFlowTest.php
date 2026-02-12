<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Mechanics;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\MassFlow;
use Monadial\Siphon\Unit\Mechanics\MassFlow\KilogramsPerHour;
use Monadial\Siphon\Unit\Mechanics\MassFlow\KilogramsPerSecond;
use Monadial\Siphon\Unit\Mechanics\MassFlow\PoundsPerSecond;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MassFlow::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(KilogramsPerSecond::class)]
#[UsesClass(PoundsPerSecond::class)]
#[UsesClass(KilogramsPerHour::class)]
final class MassFlowTest extends TestCase
{
    public function testIdentityConversion(): void
    {
        $flow = new MassFlow(BigDecimal::of('5'), KilogramsPerSecond::make());
        $result = $flow->toKilogramsPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5')));
    }

    public function testKilogramsPerSecondToKilogramsPerHour(): void
    {
        // 1 kg/s = 3600 kg/h
        $flow = new MassFlow(BigDecimal::of('1'), KilogramsPerSecond::make());
        $result = $flow->toKilogramsPerHour();

        self::assertEqualsWithDelta(3600.0, (float) (string) $result->value(), 0.01);
    }

    public function testKilogramsPerHourToKilogramsPerSecond(): void
    {
        // 3600 kg/h = 1 kg/s
        $flow = new MassFlow(BigDecimal::of('3600'), KilogramsPerHour::make());
        $result = $flow->toKilogramsPerSecond();

        self::assertEqualsWithDelta(1.0, (float) (string) $result->value(), 0.01);
    }

    public function testKilogramsPerSecondToPoundsPerSecond(): void
    {
        // 1 kg/s ≈ 2.20462 lb/s
        $flow = new MassFlow(BigDecimal::of('1'), KilogramsPerSecond::make());
        $result = $flow->toPoundsPerSecond();

        self::assertEqualsWithDelta(2.20462, (float) (string) $result->value(), 0.001);
    }

    public function testPoundsPerSecondToKilogramsPerSecond(): void
    {
        // 1 lb/s = 0.45359237 kg/s
        $flow = new MassFlow(BigDecimal::of('1'), PoundsPerSecond::make());
        $result = $flow->toKilogramsPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.45359237')));
    }

    public function testPoundsPerSecondToKilogramsPerHour(): void
    {
        // 1 lb/s = 0.45359237 kg/s = 1632.93... kg/h
        $flow = new MassFlow(BigDecimal::of('1'), PoundsPerSecond::make());
        $result = $flow->toKilogramsPerHour();

        self::assertEqualsWithDelta(1632.93, (float) (string) $result->value(), 0.1);
    }
}
