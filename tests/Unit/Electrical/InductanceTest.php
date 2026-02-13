<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Electrical;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\Inductance;
use Monadial\Siphon\Unit\Electrical\Inductance\Henrys;
use Monadial\Siphon\Unit\Electrical\Inductance\Microhenrys;
use Monadial\Siphon\Unit\Electrical\Inductance\Millihenrys;
use Monadial\Siphon\Unit\Electrical\Inductance\Nanohenrys;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Inductance::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(Nanohenrys::class)]
#[UsesClass(Microhenrys::class)]
#[UsesClass(Millihenrys::class)]
#[UsesClass(Henrys::class)]
final class InductanceTest extends TestCase
{
    public function testIdentityConversion(): void
    {
        $inductance = new Inductance(BigDecimal::of('5'), Henrys::make());
        $result = $inductance->toHenrys();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5')));
    }

    public function testHenrysToMillihenrys(): void
    {
        $inductance = new Inductance(BigDecimal::of('2.5'), Henrys::make());
        $result = $inductance->toMillihenrys();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('2500')));
    }

    public function testMillihenrysToHenrys(): void
    {
        $inductance = new Inductance(BigDecimal::of('500'), Millihenrys::make());
        $result = $inductance->toHenrys();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.5')));
    }

    public function testHenrysToMicrohenrys(): void
    {
        $inductance = new Inductance(BigDecimal::of('1'), Henrys::make());
        $result = $inductance->toMicrohenrys();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    public function testHenrysToNanohenrys(): void
    {
        $inductance = new Inductance(BigDecimal::of('1'), Henrys::make());
        $result = $inductance->toNanohenrys();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000000')));
    }

    public function testNanohenrysToMillihenrys(): void
    {
        $inductance = new Inductance(BigDecimal::of('5000000'), Nanohenrys::make());
        $result = $inductance->toMillihenrys();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5')));
    }

    public function testMicrohenrysToMillihenrys(): void
    {
        $inductance = new Inductance(BigDecimal::of('5000'), Microhenrys::make());
        $result = $inductance->toMillihenrys();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5')));
    }

    // ---------------------------------------------------------------
    // Typed factory methods (plural forms)
    // ---------------------------------------------------------------

    public function testHenrysFactory(): void
    {
        self::assertInstanceOf(Henrys::class, Inductance::henrys(1)->uom());
    }

    public function testMicrohenrysFactory(): void
    {
        self::assertInstanceOf(Microhenrys::class, Inductance::microhenrys(1)->uom());
    }

    public function testMillihenrysFactory(): void
    {
        self::assertInstanceOf(Millihenrys::class, Inductance::millihenrys(1)->uom());
    }

    public function testNanohenrysFactory(): void
    {
        self::assertInstanceOf(Nanohenrys::class, Inductance::nanohenrys(1)->uom());
    }

    // ---------------------------------------------------------------
    // Typed factory methods (singular forms)
    // ---------------------------------------------------------------

    public function testHenryFactory(): void
    {
        self::assertInstanceOf(Henrys::class, Inductance::henry(1)->uom());
    }

    public function testMicrohenryFactory(): void
    {
        self::assertInstanceOf(Microhenrys::class, Inductance::microhenry(1)->uom());
    }

    public function testMillihenryFactory(): void
    {
        self::assertInstanceOf(Millihenrys::class, Inductance::millihenry(1)->uom());
    }

    public function testNanohenryFactory(): void
    {
        self::assertInstanceOf(Nanohenrys::class, Inductance::nanohenry(1)->uom());
    }
}
