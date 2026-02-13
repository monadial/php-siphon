<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Mechanics;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\VolumeFlow;
use Monadial\Siphon\Unit\Mechanics\VolumeFlow\CubicMetersPerSecond;
use Monadial\Siphon\Unit\Mechanics\VolumeFlow\GallonsPerMinute;
use Monadial\Siphon\Unit\Mechanics\VolumeFlow\LitresPerMinute;
use Monadial\Siphon\Unit\Mechanics\VolumeFlow\LitresPerSecond;
use Monadial\Siphon\Unit\Mechanics\VolumeFlowUnit;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(VolumeFlow::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(VolumeFlowUnit::class)]
#[UsesClass(CubicMetersPerSecond::class)]
#[UsesClass(LitresPerMinute::class)]
#[UsesClass(GallonsPerMinute::class)]
#[UsesClass(LitresPerSecond::class)]
final class VolumeFlowTest extends TestCase
{
    public function testIdentityConversion(): void
    {
        $flow = new VolumeFlow(BigDecimal::of('1'), CubicMetersPerSecond::make());
        $result = $flow->toCubicMetersPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testCubicMetersPerSecondToLitresPerSecond(): void
    {
        // 1 m³/s = 1000 L/s
        $flow = new VolumeFlow(BigDecimal::of('1'), CubicMetersPerSecond::make());
        $result = $flow->toLitresPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testLitresPerSecondToCubicMetersPerSecond(): void
    {
        // 1000 L/s = 1 m³/s
        $flow = new VolumeFlow(BigDecimal::of('1000'), LitresPerSecond::make());
        $result = $flow->toCubicMetersPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testCubicMetersPerSecondToLitresPerMinute(): void
    {
        // 1 m³/s = 60000 L/min
        $flow = new VolumeFlow(BigDecimal::of('1'), CubicMetersPerSecond::make());
        $result = $flow->toLitresPerMinute();

        self::assertEqualsWithDelta(60000.0, (float) (string) $result->value(), 1.0);
    }

    public function testLitresPerMinuteToCubicMetersPerSecond(): void
    {
        // 60000 L/min ≈ 1 m³/s
        $flow = new VolumeFlow(BigDecimal::of('60000'), LitresPerMinute::make());
        $result = $flow->toCubicMetersPerSecond();

        self::assertEqualsWithDelta(1.0, (float) (string) $result->value(), 0.001);
    }

    public function testCubicMetersPerSecondToGallonsPerMinute(): void
    {
        // 1 m³/s ≈ 15850.32 GPM
        $flow = new VolumeFlow(BigDecimal::of('1'), CubicMetersPerSecond::make());
        $result = $flow->toGallonsPerMinute();

        self::assertEqualsWithDelta(15850.32, (float) (string) $result->value(), 1.0);
    }

    public function testGallonsPerMinuteToCubicMetersPerSecond(): void
    {
        // 15850 GPM ≈ 1 m³/s
        $flow = new VolumeFlow(BigDecimal::of('15850'), GallonsPerMinute::make());
        $result = $flow->toCubicMetersPerSecond();

        self::assertEqualsWithDelta(1.0, (float) (string) $result->value(), 0.001);
    }

    public function testLitresPerSecondToLitresPerMinute(): void
    {
        // 1 L/s = 60 L/min
        $flow = new VolumeFlow(BigDecimal::of('1'), LitresPerSecond::make());
        $result = $flow->toLitresPerMinute();

        self::assertEqualsWithDelta(60.0, (float) (string) $result->value(), 0.01);
    }

    // ---------------------------------------------------------------
    // Factory method coverage
    // ---------------------------------------------------------------

    public function testFactoryCubicMetersPerSecond(): void
    {
        self::assertInstanceOf(CubicMetersPerSecond::class, VolumeFlow::cubicMetersPerSecond(1)->uom());
    }

    public function testFactoryGallonsPerMinute(): void
    {
        self::assertInstanceOf(GallonsPerMinute::class, VolumeFlow::gallonsPerMinute(1)->uom());
    }

    public function testFactoryLitresPerMinute(): void
    {
        self::assertInstanceOf(LitresPerMinute::class, VolumeFlow::litresPerMinute(1)->uom());
    }

    public function testFactoryLitresPerSecond(): void
    {
        self::assertInstanceOf(LitresPerSecond::class, VolumeFlow::litresPerSecond(1)->uom());
    }

    // ---------------------------------------------------------------
    // Conversion method coverage
    // ---------------------------------------------------------------

    public function testToCubicMetersPerSecondReturnsCorrectUnit(): void
    {
        $result = VolumeFlow::litresPerSecond(1000)->toCubicMetersPerSecond();
        self::assertInstanceOf(CubicMetersPerSecond::class, $result->uom());
    }

    public function testToLitresPerMinuteReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(LitresPerMinute::class, VolumeFlow::cubicMetersPerSecond(1)->toLitresPerMinute()->uom());
    }

    public function testToGallonsPerMinuteReturnsCorrectUnit(): void
    {
        $result = VolumeFlow::cubicMetersPerSecond(1)->toGallonsPerMinute();
        self::assertInstanceOf(GallonsPerMinute::class, $result->uom());
    }

    public function testToLitresPerSecondReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(LitresPerSecond::class, VolumeFlow::cubicMetersPerSecond(1)->toLitresPerSecond()->uom());
    }
}
