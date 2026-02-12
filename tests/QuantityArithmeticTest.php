<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\UnitOfMeasure;
use Monadial\Siphon\Unit\Space\Length;
use Monadial\Siphon\Unit\Space\LengthUnit;
use Monadial\Siphon\Unit\Space\Length\Centimeters;
use Monadial\Siphon\Unit\Space\Length\Kilometers;
use Monadial\Siphon\Unit\Space\Length\Meters;
use Monadial\Siphon\Unit\Space\Length\Millimeters;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(LengthUnit::class)]
#[UsesClass(Length::class)]
#[UsesClass(Meters::class)]
#[UsesClass(Kilometers::class)]
#[UsesClass(Centimeters::class)]
#[UsesClass(Millimeters::class)]
final class QuantityArithmeticTest extends TestCase
{
    // ---------------------------------------------------------------
    // plus / minus (same dimension)
    // ---------------------------------------------------------------

    public function testPlusSameUnit(): void
    {
        $a = Length::meters(100);
        $b = Length::meters(50);
        $result = $a->plus($b);

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('150')));
        self::assertInstanceOf(Meters::class, $result->uom());
    }

    public function testPlusCrossUnit(): void
    {
        $a = Length::kilometers(1);
        $b = Length::meters(500);
        $result = $a->plus($b);

        self::assertEqualsWithDelta(1.5, (float) (string) $result->value(), 0.0001);
        self::assertInstanceOf(Kilometers::class, $result->uom());
    }

    public function testMinusSameUnit(): void
    {
        $a = Length::meters(100);
        $b = Length::meters(30);
        $result = $a->minus($b);

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('70')));
    }

    public function testMinusCrossUnit(): void
    {
        $a = Length::meters(1000);
        $b = Length::kilometers(1);
        $result = $a->minus($b);

        self::assertEqualsWithDelta(0.0, (float) (string) $result->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // times / dividedBy (scalar)
    // ---------------------------------------------------------------

    public function testTimesScalar(): void
    {
        $length = Length::meters(10);
        $result = $length->times(3);

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('30')));
        self::assertInstanceOf(Meters::class, $result->uom());
    }

    public function testTimesDecimalScalar(): void
    {
        $length = Length::meters(10);
        $result = $length->times('2.5');

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('25.0')));
    }

    public function testDividedByScalar(): void
    {
        $length = Length::meters(100);
        $result = $length->dividedBy(4);

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('25')));
        self::assertInstanceOf(Meters::class, $result->uom());
    }

    public function testDividedByDecimalScalar(): void
    {
        $length = Length::meters(10);
        $result = $length->dividedBy('3');

        self::assertEqualsWithDelta(3.3333, (float) (string) $result->value(), 0.001);
    }

    // ---------------------------------------------------------------
    // negate / abs
    // ---------------------------------------------------------------

    public function testNegate(): void
    {
        $length = Length::meters(42);
        $result = $length->negate();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('-42')));
        self::assertInstanceOf(Meters::class, $result->uom());
    }

    public function testNegateNegativeValue(): void
    {
        $length = Length::meters(-42);
        $result = $length->negate();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('42')));
    }

    public function testAbs(): void
    {
        $length = Length::meters(-42);
        $result = $length->abs();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('42')));
    }

    public function testAbsPositiveValue(): void
    {
        $length = Length::meters(42);
        $result = $length->abs();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('42')));
    }

    // ---------------------------------------------------------------
    // Comparisons
    // ---------------------------------------------------------------

    public function testIsEqualToSameUnit(): void
    {
        $a = Length::meters(100);
        $b = Length::meters(100);

        self::assertTrue($a->isEqualTo($b));
    }

    public function testIsEqualToCrossUnit(): void
    {
        $a = Length::meters(1000);
        $b = Length::kilometers(1);

        self::assertTrue($a->isEqualTo($b));
    }

    public function testIsNotEqualTo(): void
    {
        $a = Length::meters(100);
        $b = Length::meters(200);

        self::assertFalse($a->isEqualTo($b));
    }

    public function testIsGreaterThan(): void
    {
        $a = Length::meters(200);
        $b = Length::meters(100);

        self::assertTrue($a->isGreaterThan($b));
        self::assertFalse($b->isGreaterThan($a));
    }

    public function testIsGreaterThanCrossUnit(): void
    {
        $a = Length::kilometers(2);
        $b = Length::meters(1500);

        self::assertTrue($a->isGreaterThan($b));
    }

    public function testIsLessThan(): void
    {
        $a = Length::meters(50);
        $b = Length::meters(100);

        self::assertTrue($a->isLessThan($b));
        self::assertFalse($b->isLessThan($a));
    }

    public function testIsGreaterThanOrEqualTo(): void
    {
        $a = Length::meters(100);
        $b = Length::meters(100);
        $c = Length::meters(50);

        self::assertTrue($a->isGreaterThanOrEqualTo($b));
        self::assertTrue($a->isGreaterThanOrEqualTo($c));
        self::assertFalse($c->isGreaterThanOrEqualTo($a));
    }

    public function testIsLessThanOrEqualTo(): void
    {
        $a = Length::meters(100);
        $b = Length::meters(100);
        $c = Length::meters(200);

        self::assertTrue($a->isLessThanOrEqualTo($b));
        self::assertTrue($a->isLessThanOrEqualTo($c));
        self::assertFalse($c->isLessThanOrEqualTo($a));
    }

    // ---------------------------------------------------------------
    // approx
    // ---------------------------------------------------------------

    public function testApproxWithinTolerance(): void
    {
        $a = Length::meters(100);
        $b = Length::meters('100.005');
        $tolerance = Length::meters('0.01');

        self::assertTrue($a->approx($b, $tolerance));
    }

    public function testApproxOutsideTolerance(): void
    {
        $a = Length::meters(100);
        $b = Length::meters(101);
        $tolerance = Length::meters('0.5');

        self::assertFalse($a->approx($b, $tolerance));
    }

    public function testApproxCrossUnit(): void
    {
        $a = Length::kilometers(1);
        $b = Length::meters(1001);
        $tolerance = Length::meters(2);

        self::assertTrue($a->approx($b, $tolerance));
    }

    // ---------------------------------------------------------------
    // min / max
    // ---------------------------------------------------------------

    public function testMin(): void
    {
        $a = Length::meters(100);
        $b = Length::meters(50);
        $c = Length::meters(200);

        $result = $a->min($b, $c);

        self::assertEqualsWithDelta(50.0, (float) (string) $result->value(), 0.0001);
    }

    public function testMinCrossUnit(): void
    {
        $a = Length::kilometers(1);
        $b = Length::meters(500);

        $result = $a->min($b);

        self::assertEqualsWithDelta(0.5, (float) (string) $result->value(), 0.0001);
        self::assertInstanceOf(Kilometers::class, $result->uom());
    }

    public function testMax(): void
    {
        $a = Length::meters(100);
        $b = Length::meters(50);
        $c = Length::meters(200);

        $result = $a->max($b, $c);

        self::assertEqualsWithDelta(200.0, (float) (string) $result->value(), 0.0001);
    }

    public function testMaxCrossUnit(): void
    {
        $a = Length::meters(500);
        $b = Length::kilometers(1);

        $result = $a->max($b);

        self::assertEqualsWithDelta(1000.0, (float) (string) $result->value(), 0.0001);
        self::assertInstanceOf(Meters::class, $result->uom());
    }

    // ---------------------------------------------------------------
    // DSL convenience: in / to / map
    // ---------------------------------------------------------------

    public function testIn(): void
    {
        $length = Length::meters(1000);
        $result = $length->in(Kilometers::make());

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
        self::assertInstanceOf(Kilometers::class, $result->uom());
        self::assertInstanceOf(Length::class, $result);
    }

    public function testTo(): void
    {
        $length = Length::meters(1000);
        $value = $length->to(Kilometers::make());

        self::assertInstanceOf(BigDecimal::class, $value);
        self::assertTrue($value->isEqualTo(BigDecimal::of('1')));
    }

    public function testMap(): void
    {
        $length = Length::meters(10);
        $result = $length->map(static fn (BigDecimal $v): BigDecimal => $v->multipliedBy(2)->plus(5));

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('25')));
        self::assertInstanceOf(Meters::class, $result->uom());
        self::assertInstanceOf(Length::class, $result);
    }

    // ---------------------------------------------------------------
    // Immutability
    // ---------------------------------------------------------------

    public function testArithmeticDoesNotMutate(): void
    {
        $original = Length::meters(100);
        $original->plus(Length::meters(50));
        $original->times(3);
        $original->negate();

        self::assertTrue($original->value()->isEqualTo(BigDecimal::of('100')));
    }

    // ---------------------------------------------------------------
    // Chaining
    // ---------------------------------------------------------------

    public function testMethodChaining(): void
    {
        $result = Length::meters(10)
            ->times(3)
            ->plus(Length::meters(20))
            ->minus(Length::centimeters(500))
            ->in(Kilometers::make());

        self::assertEqualsWithDelta(0.045, (float) (string) $result->value(), 0.0001);
    }
}
