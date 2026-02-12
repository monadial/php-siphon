<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Light;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Light\LuminousIntensity;
use Monadial\Siphon\Unit\Light\LuminousIntensity\Candelas;
use Monadial\Siphon\Unit\Light\LuminousIntensity\Kilocandelas;
use Monadial\Siphon\Unit\Light\LuminousIntensity\Millicandelas;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LuminousIntensity::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(Millicandelas::class)]
#[UsesClass(Candelas::class)]
#[UsesClass(Kilocandelas::class)]
final class LuminousIntensityTest extends TestCase
{
    public function testIdentityConversion(): void
    {
        $intensity = new LuminousIntensity(BigDecimal::of('100'), Candelas::make());
        $result = $intensity->toCandelas();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('100')));
    }

    public function testCandelasToMillicandelas(): void
    {
        $intensity = new LuminousIntensity(BigDecimal::of('1'), Candelas::make());
        $result = $intensity->toMillicandelas();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testMillicandelasToCandelmas(): void
    {
        $intensity = new LuminousIntensity(BigDecimal::of('500'), Millicandelas::make());
        $result = $intensity->toCandelas();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.5')));
    }

    public function testCandelasToKilocandelas(): void
    {
        $intensity = new LuminousIntensity(BigDecimal::of('5000'), Candelas::make());
        $result = $intensity->toKilocandelas();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5')));
    }

    public function testKilocandelasToCandelas(): void
    {
        $intensity = new LuminousIntensity(BigDecimal::of('2.5'), Kilocandelas::make());
        $result = $intensity->toCandelas();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('2500')));
    }

    public function testKilocandelasToMillicandelas(): void
    {
        $intensity = new LuminousIntensity(BigDecimal::of('1'), Kilocandelas::make());
        $result = $intensity->toMillicandelas();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }
}
