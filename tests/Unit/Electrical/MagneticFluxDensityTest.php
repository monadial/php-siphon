<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Electrical;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\MagneticFluxDensity;
use Monadial\Siphon\Unit\Electrical\MagneticFluxDensity\Gauss;
use Monadial\Siphon\Unit\Electrical\MagneticFluxDensity\Microteslas;
use Monadial\Siphon\Unit\Electrical\MagneticFluxDensity\Milliteslas;
use Monadial\Siphon\Unit\Electrical\MagneticFluxDensity\Teslas;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MagneticFluxDensity::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(Microteslas::class)]
#[UsesClass(Milliteslas::class)]
#[UsesClass(Teslas::class)]
#[UsesClass(Gauss::class)]
final class MagneticFluxDensityTest extends TestCase
{
    public function testIdentityConversion(): void
    {
        $density = new MagneticFluxDensity(BigDecimal::of('5'), Teslas::make());
        $result = $density->toTeslas();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5')));
    }

    public function testTeslasToMilliteslas(): void
    {
        $density = new MagneticFluxDensity(BigDecimal::of('2.5'), Teslas::make());
        $result = $density->toMilliteslas();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('2500')));
    }

    public function testMilliteslasToTeslas(): void
    {
        $density = new MagneticFluxDensity(BigDecimal::of('500'), Milliteslas::make());
        $result = $density->toTeslas();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.5')));
    }

    public function testTeslasToMicroteslas(): void
    {
        $density = new MagneticFluxDensity(BigDecimal::of('1'), Teslas::make());
        $result = $density->toMicroteslas();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    public function testTeslasToGauss(): void
    {
        $density = new MagneticFluxDensity(BigDecimal::of('1'), Teslas::make());
        $result = $density->toGauss();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('10000')));
    }

    public function testGaussToTeslas(): void
    {
        $density = new MagneticFluxDensity(BigDecimal::of('10000'), Gauss::make());
        $result = $density->toTeslas();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testGaussToMilliteslas(): void
    {
        $density = new MagneticFluxDensity(BigDecimal::of('10'), Gauss::make());
        $result = $density->toMilliteslas();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testMicroteslasToGauss(): void
    {
        $density = new MagneticFluxDensity(BigDecimal::of('100'), Microteslas::make());
        $result = $density->toGauss();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    // ---------------------------------------------------------------
    // Typed factory methods (plural forms)
    // ---------------------------------------------------------------

    public function testTeslasFactory(): void
    {
        self::assertInstanceOf(Teslas::class, MagneticFluxDensity::teslas(1)->uom());
    }

    public function testMilliteslasFactory(): void
    {
        self::assertInstanceOf(Milliteslas::class, MagneticFluxDensity::milliteslas(1)->uom());
    }

    public function testMicroteslasFactory(): void
    {
        self::assertInstanceOf(Microteslas::class, MagneticFluxDensity::microteslas(1)->uom());
    }

    public function testGaussFactory(): void
    {
        self::assertInstanceOf(Gauss::class, MagneticFluxDensity::gauss(1)->uom());
    }

    // ---------------------------------------------------------------
    // Typed factory methods (singular forms)
    // ---------------------------------------------------------------

    public function testTeslaFactory(): void
    {
        self::assertInstanceOf(Teslas::class, MagneticFluxDensity::tesla(1)->uom());
    }

    public function testMilliteslaFactory(): void
    {
        self::assertInstanceOf(Milliteslas::class, MagneticFluxDensity::millitesla(1)->uom());
    }

    public function testMicroteslaFactory(): void
    {
        self::assertInstanceOf(Microteslas::class, MagneticFluxDensity::microtesla(1)->uom());
    }

    public function testGausFactory(): void
    {
        self::assertInstanceOf(Gauss::class, MagneticFluxDensity::gaus(1)->uom());
    }
}
