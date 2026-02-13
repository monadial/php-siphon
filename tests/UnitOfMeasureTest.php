<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Exception\UnitNotFound;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Tests\Stub\OrphanUnit;
use Monadial\Siphon\Unit\Mechanics\Power;
use Monadial\Siphon\Unit\Mechanics\Power\Watts;
use Monadial\Siphon\Unit\Space\Area\SquareMeters;
use Monadial\Siphon\Unit\Space\Length;
use Monadial\Siphon\Unit\Space\Length\Centimeters;
use Monadial\Siphon\Unit\Space\Length\Kilometers;
use Monadial\Siphon\Unit\Space\Length\Meters;
use Monadial\Siphon\Unit\Space\Length\Millimeters;
use Monadial\Siphon\Unit\Temperature\Temperature\Celsius;
use Monadial\Siphon\Unit\Temperature\TemperatureUnit;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(Meters::class)]
#[UsesClass(Centimeters::class)]
#[UsesClass(Kilometers::class)]
#[UsesClass(Millimeters::class)]
#[UsesClass(SquareMeters::class)]
#[UsesClass(Length::class)]
#[UsesClass(Power::class)]
#[UsesClass(Watts::class)]
#[UsesClass(Celsius::class)]
#[UsesClass(TemperatureUnit::class)]
final class UnitOfMeasureTest extends TestCase
{
    public function testMakeReturnsInstanceOfMeters(): void
    {
        $meters = Meters::make();

        self::assertInstanceOf(Meters::class, $meters);
        self::assertInstanceOf(UnitOfMeasure::class, $meters);
    }

    public function testMakeReturnsInstanceOfCentimeters(): void
    {
        $centimeters = Centimeters::make();

        self::assertInstanceOf(Centimeters::class, $centimeters);
        self::assertInstanceOf(UnitOfMeasure::class, $centimeters);
    }

    public function testEqualsReturnsTrueForSameClass(): void
    {
        $metersA = Meters::make();
        $metersB = Meters::make();

        self::assertTrue($metersA->equals($metersB));
    }

    public function testEqualsReturnsFalseForDifferentClass(): void
    {
        $meters = Meters::make();
        $centimeters = Centimeters::make();

        self::assertFalse($meters->equals($centimeters));
    }

    public function testEqualsReturnsFalseForDifferentDimensions(): void
    {
        $meters = Meters::make();
        $squareMeters = SquareMeters::make();

        self::assertFalse($meters->equals($squareMeters));
    }

    public function testEqualsIsSymmetric(): void
    {
        $meters = Meters::make();
        $centimeters = Centimeters::make();

        self::assertFalse($meters->equals($centimeters));
        self::assertFalse($centimeters->equals($meters));
    }

    public function testEqualsIsReflexive(): void
    {
        $meters = Meters::make();

        self::assertTrue($meters->equals($meters));
    }

    public function testMakeReturnsNewInstanceEachTime(): void
    {
        $first = Meters::make();
        $second = Meters::make();

        self::assertTrue($first->equals($second));
    }

    public function testFactorReturnsBigDecimalForConcreteUnits(): void
    {
        self::assertInstanceOf(BigDecimal::class, Meters::make()->factor());
        self::assertInstanceOf(BigDecimal::class, Centimeters::make()->factor());
        self::assertInstanceOf(BigDecimal::class, Kilometers::make()->factor());
        self::assertInstanceOf(BigDecimal::class, Millimeters::make()->factor());
    }

    public function testMetersFactorIsOne(): void
    {
        self::assertTrue(Meters::make()->factor()->isEqualTo(BigDecimal::one()));
    }

    public function testCentimetersFactorIsOneHundredth(): void
    {
        self::assertTrue(Centimeters::make()->factor()->isEqualTo(BigDecimal::of('0.01')));
    }

    public function testKilometersFactorIsOneThousand(): void
    {
        self::assertTrue(Kilometers::make()->factor()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testMillimetersFactorIsOneThousandth(): void
    {
        self::assertTrue(Millimeters::make()->factor()->isEqualTo(BigDecimal::of('0.001')));
    }

    /** @throws UnitNotFound */
    public function testFromCreatesLengthQuantityFromUnit(): void
    {
        $length = Meters::from(12);

        self::assertInstanceOf(Length::class, $length);
        self::assertTrue($length->value()->isEqualTo(BigDecimal::of('12')));
        self::assertInstanceOf(Meters::class, $length->uom());
    }

    /** @throws UnitNotFound */
    public function testFromCreatesPowerQuantityFromUnit(): void
    {
        $power = Watts::from('100.5');

        self::assertInstanceOf(Power::class, $power);
        self::assertTrue($power->value()->isEqualTo(BigDecimal::of('100.5')));
        self::assertInstanceOf(Watts::class, $power->uom());
    }

    public function testNameReturnsSingleWordLowercased(): void
    {
        self::assertSame('meters', Meters::make()->name());
    }

    public function testNameConvertsMultiWordPascalCaseToLowercaseWithSpaces(): void
    {
        self::assertSame('square meters', SquareMeters::make()->name());
    }

    public function testSymbolReturnsUnitSymbol(): void
    {
        self::assertSame('m', Meters::make()->symbol());
        self::assertSame('cm', Centimeters::make()->symbol());
        self::assertSame('km', Kilometers::make()->symbol());
    }

    public function testOffsetReturnsZeroForLinearUnits(): void
    {
        self::assertTrue(Meters::make()->offset()->isEqualTo(BigDecimal::zero()));
    }

    public function testOffsetReturnsNonZeroForAffineUnits(): void
    {
        $offset = Celsius::make()->offset();

        self::assertFalse($offset->isEqualTo(BigDecimal::zero()));
        self::assertTrue($offset->isEqualTo(BigDecimal::of('273.15')));
    }

    /** @throws UnitNotFound */
    public function testFromThrowsWhenQuantityClassCannotBeInferred(): void
    {
        $this->expectException(UnitNotFound::class);
        $this->expectExceptionMessage('Unable to infer quantity class for unit');

        OrphanUnit::from(42);
    }
}
