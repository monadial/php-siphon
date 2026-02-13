<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Light;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Light\LuminousFlux;
use Monadial\Siphon\Unit\Light\LuminousFlux\Kilolumens;
use Monadial\Siphon\Unit\Light\LuminousFlux\Lumens;
use Monadial\Siphon\Unit\Light\LuminousFlux\Millilumens;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LuminousFlux::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(Millilumens::class)]
#[UsesClass(Lumens::class)]
#[UsesClass(Kilolumens::class)]
final class LuminousFluxTest extends TestCase
{
    public function testIdentityConversion(): void
    {
        $flux = new LuminousFlux(BigDecimal::of('100'), Lumens::make());
        $result = $flux->toLumens();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('100')));
    }

    public function testLumensToMillilumens(): void
    {
        $flux = new LuminousFlux(BigDecimal::of('1'), Lumens::make());
        $result = $flux->toMillilumens();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testMillilumensToLumens(): void
    {
        $flux = new LuminousFlux(BigDecimal::of('500'), Millilumens::make());
        $result = $flux->toLumens();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.5')));
    }

    public function testLumensToKilolumens(): void
    {
        $flux = new LuminousFlux(BigDecimal::of('5000'), Lumens::make());
        $result = $flux->toKilolumens();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5')));
    }

    public function testKilolumensToLumens(): void
    {
        $flux = new LuminousFlux(BigDecimal::of('2.5'), Kilolumens::make());
        $result = $flux->toLumens();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('2500')));
    }

    public function testKilolumensToMillilumens(): void
    {
        $flux = new LuminousFlux(BigDecimal::of('1'), Kilolumens::make());
        $result = $flux->toMillilumens();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    // ---------------------------------------------------------------
    // Typed factory methods (plural forms)
    // ---------------------------------------------------------------

    public function testKilolumensFactory(): void
    {
        self::assertInstanceOf(Kilolumens::class, LuminousFlux::kilolumens(1)->uom());
    }

    public function testLumensFactory(): void
    {
        self::assertInstanceOf(Lumens::class, LuminousFlux::lumens(1)->uom());
    }

    public function testMillilumensFactory(): void
    {
        self::assertInstanceOf(Millilumens::class, LuminousFlux::millilumens(1)->uom());
    }

    // ---------------------------------------------------------------
    // Typed factory methods (singular forms)
    // ---------------------------------------------------------------

    public function testKilolumenFactory(): void
    {
        self::assertInstanceOf(Kilolumens::class, LuminousFlux::kilolumen(1)->uom());
    }

    public function testLumenFactory(): void
    {
        self::assertInstanceOf(Lumens::class, LuminousFlux::lumen(1)->uom());
    }

    public function testMillilumenFactory(): void
    {
        self::assertInstanceOf(Millilumens::class, LuminousFlux::millilumen(1)->uom());
    }
}
