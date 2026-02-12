<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Electrical;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Electrical\MagneticFlux;
use Monadial\Siphon\Unit\Electrical\MagneticFlux\Microwebers;
use Monadial\Siphon\Unit\Electrical\MagneticFlux\Milliwebers;
use Monadial\Siphon\Unit\Electrical\MagneticFlux\Webers;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MagneticFlux::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(Microwebers::class)]
#[UsesClass(Milliwebers::class)]
#[UsesClass(Webers::class)]
final class MagneticFluxTest extends TestCase
{
    public function testIdentityConversion(): void
    {
        $flux = new MagneticFlux(BigDecimal::of('5'), Webers::make());
        $result = $flux->toWebers();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5')));
    }

    public function testWebersToMilliwebers(): void
    {
        $flux = new MagneticFlux(BigDecimal::of('2.5'), Webers::make());
        $result = $flux->toMilliwebers();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('2500')));
    }

    public function testMilliwebersToWebers(): void
    {
        $flux = new MagneticFlux(BigDecimal::of('500'), Milliwebers::make());
        $result = $flux->toWebers();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.5')));
    }

    public function testWebersToMicrowebers(): void
    {
        $flux = new MagneticFlux(BigDecimal::of('1'), Webers::make());
        $result = $flux->toMicrowebers();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    public function testMicrowebersToWebers(): void
    {
        $flux = new MagneticFlux(BigDecimal::of('1000000'), Microwebers::make());
        $result = $flux->toWebers();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testMicrowebersToMilliwebers(): void
    {
        $flux = new MagneticFlux(BigDecimal::of('5000'), Microwebers::make());
        $result = $flux->toMilliwebers();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5')));
    }
}
