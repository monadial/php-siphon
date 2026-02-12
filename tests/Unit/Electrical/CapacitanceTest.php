<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Electrical;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Electrical\Capacitance;
use Monadial\Siphon\Unit\Electrical\Capacitance\Farads;
use Monadial\Siphon\Unit\Electrical\Capacitance\Kilofarads;
use Monadial\Siphon\Unit\Electrical\Capacitance\Microfarads;
use Monadial\Siphon\Unit\Electrical\Capacitance\Millifarads;
use Monadial\Siphon\Unit\Electrical\Capacitance\Nanofarads;
use Monadial\Siphon\Unit\Electrical\Capacitance\Picofarads;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
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
}
