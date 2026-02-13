<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Electrical;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricCurrent;
use Monadial\Siphon\Unit\Electrical\ElectricCurrent\Amperes;
use Monadial\Siphon\Unit\Electrical\ElectricCurrent\Kiloamperes;
use Monadial\Siphon\Unit\Electrical\ElectricCurrent\Microamperes;
use Monadial\Siphon\Unit\Electrical\ElectricCurrent\Milliamperes;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ElectricCurrent::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(Microamperes::class)]
#[UsesClass(Milliamperes::class)]
#[UsesClass(Amperes::class)]
#[UsesClass(Kiloamperes::class)]
final class ElectricCurrentTest extends TestCase
{
    public function testIdentityConversion(): void
    {
        $current = new ElectricCurrent(BigDecimal::of('5'), Amperes::make());
        $result = $current->toAmperes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5')));
    }

    public function testAmperesToMilliamperes(): void
    {
        $current = new ElectricCurrent(BigDecimal::of('2.5'), Amperes::make());
        $result = $current->toMilliamperes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('2500')));
    }

    public function testMilliamperesToAmperes(): void
    {
        $current = new ElectricCurrent(BigDecimal::of('500'), Milliamperes::make());
        $result = $current->toAmperes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.5')));
    }

    public function testAmperesToMicroamperes(): void
    {
        $current = new ElectricCurrent(BigDecimal::of('1'), Amperes::make());
        $result = $current->toMicroamperes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    public function testAmperesToKiloamperes(): void
    {
        $current = new ElectricCurrent(BigDecimal::of('5000'), Amperes::make());
        $result = $current->toKiloamperes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5')));
    }

    public function testKiloamperesToMilliamperes(): void
    {
        $current = new ElectricCurrent(BigDecimal::of('1'), Kiloamperes::make());
        $result = $current->toMilliamperes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    public function testMicroamperesToMilliamperes(): void
    {
        $current = new ElectricCurrent(BigDecimal::of('5000'), Microamperes::make());
        $result = $current->toMilliamperes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5')));
    }

    // ---------------------------------------------------------------
    // Typed factory methods (plural forms)
    // ---------------------------------------------------------------

    public function testAmperesFactory(): void
    {
        self::assertInstanceOf(Amperes::class, ElectricCurrent::amperes(1)->uom());
    }

    public function testKiloamperesFactory(): void
    {
        self::assertInstanceOf(Kiloamperes::class, ElectricCurrent::kiloamperes(1)->uom());
    }

    public function testMicroamperesFactory(): void
    {
        self::assertInstanceOf(Microamperes::class, ElectricCurrent::microamperes(1)->uom());
    }

    public function testMilliamperesFactory(): void
    {
        self::assertInstanceOf(Milliamperes::class, ElectricCurrent::milliamperes(1)->uom());
    }

    // ---------------------------------------------------------------
    // Typed factory methods (singular forms)
    // ---------------------------------------------------------------

    public function testAmpereFactory(): void
    {
        self::assertInstanceOf(Amperes::class, ElectricCurrent::ampere(1)->uom());
    }

    public function testKiloampereFactory(): void
    {
        self::assertInstanceOf(Kiloamperes::class, ElectricCurrent::kiloampere(1)->uom());
    }

    public function testMicroampereFactory(): void
    {
        self::assertInstanceOf(Microamperes::class, ElectricCurrent::microampere(1)->uom());
    }

    public function testMilliampereFactory(): void
    {
        self::assertInstanceOf(Milliamperes::class, ElectricCurrent::milliampere(1)->uom());
    }
}
