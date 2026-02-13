<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Mechanics;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\Density;
use Monadial\Siphon\Unit\Mechanics\Density\GramsPerCubicCentimeter;
use Monadial\Siphon\Unit\Mechanics\Density\GramsPerLitre;
use Monadial\Siphon\Unit\Mechanics\Density\KilogramsPerCubicMeter;
use Monadial\Siphon\Unit\Mechanics\DensityUnit;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Density::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(DensityUnit::class)]
#[UsesClass(KilogramsPerCubicMeter::class)]
#[UsesClass(GramsPerCubicCentimeter::class)]
#[UsesClass(GramsPerLitre::class)]
final class DensityTest extends TestCase
{
    public function testIdentityConversion(): void
    {
        $density = new Density(BigDecimal::of('1000'), KilogramsPerCubicMeter::make());
        $result = $density->toKilogramsPerCubicMeter();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testKilogramsPerCubicMeterToGramsPerCubicCentimeter(): void
    {
        // 1000 kg/m³ = 1 g/cm³
        $density = new Density(BigDecimal::of('1000'), KilogramsPerCubicMeter::make());
        $result = $density->toGramsPerCubicCentimeter();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testGramsPerCubicCentimeterToKilogramsPerCubicMeter(): void
    {
        // 1 g/cm³ = 1000 kg/m³
        $density = new Density(BigDecimal::of('1'), GramsPerCubicCentimeter::make());
        $result = $density->toKilogramsPerCubicMeter();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testKilogramsPerCubicMeterToGramsPerLitre(): void
    {
        // 1 kg/m³ = 1 g/L (same factor)
        $density = new Density(BigDecimal::of('500'), KilogramsPerCubicMeter::make());
        $result = $density->toGramsPerLitre();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('500')));
    }

    public function testGramsPerLitreToKilogramsPerCubicMeter(): void
    {
        // 1 g/L = 1 kg/m³
        $density = new Density(BigDecimal::of('250'), GramsPerLitre::make());
        $result = $density->toKilogramsPerCubicMeter();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('250')));
    }

    public function testGramsPerCubicCentimeterToGramsPerLitre(): void
    {
        // 1 g/cm³ = 1000 g/L
        $density = new Density(BigDecimal::of('1'), GramsPerCubicCentimeter::make());
        $result = $density->toGramsPerLitre();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testGramsPerLitreToGramsPerCubicCentimeter(): void
    {
        // 1000 g/L = 1 g/cm³
        $density = new Density(BigDecimal::of('1000'), GramsPerLitre::make());
        $result = $density->toGramsPerCubicCentimeter();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testWaterDensity(): void
    {
        // Water: 997 kg/m³ ≈ 0.997 g/cm³
        $density = new Density(BigDecimal::of('997'), KilogramsPerCubicMeter::make());
        $result = $density->toGramsPerCubicCentimeter();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.997')));
    }

    // ---------------------------------------------------------------
    // Factory method coverage
    // ---------------------------------------------------------------

    public function testFactoryGramsPerCubicCentimeter(): void
    {
        self::assertInstanceOf(GramsPerCubicCentimeter::class, Density::gramsPerCubicCentimeter(1)->uom());
    }

    public function testFactoryGramsPerLitre(): void
    {
        self::assertInstanceOf(GramsPerLitre::class, Density::gramsPerLitre(1)->uom());
    }

    public function testFactoryKilogramsPerCubicMeter(): void
    {
        self::assertInstanceOf(KilogramsPerCubicMeter::class, Density::kilogramsPerCubicMeter(1)->uom());
    }

    // ---------------------------------------------------------------
    // Conversion method coverage
    // ---------------------------------------------------------------

    public function testToKilogramsPerCubicMeterReturnsCorrectUnit(): void
    {
        $result = Density::gramsPerCubicCentimeter(1)->toKilogramsPerCubicMeter();
        self::assertInstanceOf(KilogramsPerCubicMeter::class, $result->uom());
    }

    public function testToGramsPerCubicCentimeterReturnsCorrectUnit(): void
    {
        $result = Density::kilogramsPerCubicMeter(1000)->toGramsPerCubicCentimeter();
        self::assertInstanceOf(GramsPerCubicCentimeter::class, $result->uom());
    }

    public function testToGramsPerLitreReturnsCorrectUnit(): void
    {
        self::assertInstanceOf(GramsPerLitre::class, Density::kilogramsPerCubicMeter(1)->toGramsPerLitre()->uom());
    }
}
