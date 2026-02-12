<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Mechanics;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\Momentum;
use Monadial\Siphon\Unit\Mechanics\Momentum\KilogramMetersPerSecond;
use Monadial\Siphon\Unit\Mechanics\Momentum\NewtonSeconds;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Momentum::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(NewtonSeconds::class)]
#[UsesClass(KilogramMetersPerSecond::class)]
final class MomentumTest extends TestCase
{
    public function testIdentityConversion(): void
    {
        $momentum = new Momentum(BigDecimal::of('100'), NewtonSeconds::make());
        $result = $momentum->toNewtonSeconds();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('100')));
    }

    public function testNewtonSecondsToKilogramMetersPerSecond(): void
    {
        // 1 N·s = 1 kg·m/s (same factor)
        $momentum = new Momentum(BigDecimal::of('50'), NewtonSeconds::make());
        $result = $momentum->toKilogramMetersPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('50')));
    }

    public function testKilogramMetersPerSecondToNewtonSeconds(): void
    {
        // 1 kg·m/s = 1 N·s (same factor)
        $momentum = new Momentum(BigDecimal::of('75.5'), KilogramMetersPerSecond::make());
        $result = $momentum->toNewtonSeconds();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('75.5')));
    }

    public function testRoundTripConversion(): void
    {
        $original = new Momentum(BigDecimal::of('123.456'), NewtonSeconds::make());
        $converted = $original->toKilogramMetersPerSecond();
        $roundTrip = $converted->toNewtonSeconds();

        self::assertTrue($roundTrip->value()->isEqualTo(BigDecimal::of('123.456')));
    }

    public function testZeroMomentum(): void
    {
        $momentum = new Momentum(BigDecimal::of('0'), NewtonSeconds::make());
        $result = $momentum->toKilogramMetersPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0')));
    }
}
