<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Electrical;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\Capacitance;
use Monadial\Siphon\Unit\Electrical\Capacitance\Farads;
use Monadial\Siphon\Unit\Electrical\Capacitance\Kilofarads;
use Monadial\Siphon\Unit\Electrical\Capacitance\Microfarads;
use Monadial\Siphon\Unit\Electrical\Capacitance\Millifarads;
use Monadial\Siphon\Unit\Electrical\Capacitance\Nanofarads;
use Monadial\Siphon\Unit\Electrical\Capacitance\Picofarads;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Capacitance::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(Picofarads::class)]
#[UsesClass(Nanofarads::class)]
#[UsesClass(Microfarads::class)]
#[UsesClass(Millifarads::class)]
#[UsesClass(Farads::class)]
#[UsesClass(Kilofarads::class)]
final class CapacitanceTest extends TestCase
{
    public function testIdentityConversion(): void
    {
        $capacitance = new Capacitance(BigDecimal::of('10'), Farads::make());
        $result = $capacitance->toFarads();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('10')));
    }

    public function testFaradsToMillifarads(): void
    {
        $capacitance = new Capacitance(BigDecimal::of('2.5'), Farads::make());
        $result = $capacitance->toMillifarads();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('2500')));
    }

    public function testMillifaradsToFarads(): void
    {
        $capacitance = new Capacitance(BigDecimal::of('500'), Millifarads::make());
        $result = $capacitance->toFarads();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.5')));
    }

    public function testFaradsToMicrofarads(): void
    {
        $capacitance = new Capacitance(BigDecimal::of('1'), Farads::make());
        $result = $capacitance->toMicrofarads();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    public function testFaradsToNanofarads(): void
    {
        $capacitance = new Capacitance(BigDecimal::of('1'), Farads::make());
        $result = $capacitance->toNanofarads();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000000')));
    }

    public function testFaradsToKilofarads(): void
    {
        $capacitance = new Capacitance(BigDecimal::of('5000'), Farads::make());
        $result = $capacitance->toKilofarads();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5')));
    }

    public function testPicofaradsToFarads(): void
    {
        $capacitance = new Capacitance(BigDecimal::of('1000000000000'), Picofarads::make());
        $result = $capacitance->toFarads();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testKilofaradsToPicofarads(): void
    {
        $capacitance = new Capacitance(BigDecimal::of('1'), Kilofarads::make());
        $result = $capacitance->toPicofarads();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000000000000')));
    }

    public function testNanofaradsToMicrofarads(): void
    {
        $capacitance = new Capacitance(BigDecimal::of('5000'), Nanofarads::make());
        $result = $capacitance->toMicrofarads();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5')));
    }

    // ---------------------------------------------------------------
    // Typed factory methods (plural forms)
    // ---------------------------------------------------------------

    public function testFaradsFactory(): void
    {
        self::assertInstanceOf(Farads::class, Capacitance::farads(1)->uom());
    }

    public function testKilofaradsFactory(): void
    {
        self::assertInstanceOf(Kilofarads::class, Capacitance::kilofarads(1)->uom());
    }

    public function testMicrofaradsFactory(): void
    {
        self::assertInstanceOf(Microfarads::class, Capacitance::microfarads(1)->uom());
    }

    public function testMillifaradsFactory(): void
    {
        self::assertInstanceOf(Millifarads::class, Capacitance::millifarads(1)->uom());
    }

    public function testNanofaradsFactory(): void
    {
        self::assertInstanceOf(Nanofarads::class, Capacitance::nanofarads(1)->uom());
    }

    public function testPicofaradsFactory(): void
    {
        self::assertInstanceOf(Picofarads::class, Capacitance::picofarads(1)->uom());
    }

    // ---------------------------------------------------------------
    // Typed factory methods (singular forms)
    // ---------------------------------------------------------------

    public function testFaradFactory(): void
    {
        self::assertInstanceOf(Farads::class, Capacitance::farad(1)->uom());
    }

    public function testKilofaradFactory(): void
    {
        self::assertInstanceOf(Kilofarads::class, Capacitance::kilofarad(1)->uom());
    }

    public function testMicrofaradFactory(): void
    {
        self::assertInstanceOf(Microfarads::class, Capacitance::microfarad(1)->uom());
    }

    public function testMillifaradFactory(): void
    {
        self::assertInstanceOf(Millifarads::class, Capacitance::millifarad(1)->uom());
    }

    public function testNanofaradFactory(): void
    {
        self::assertInstanceOf(Nanofarads::class, Capacitance::nanofarad(1)->uom());
    }

    public function testPicofaradFactory(): void
    {
        self::assertInstanceOf(Picofarads::class, Capacitance::picofarad(1)->uom());
    }
}
