<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Dimensionless;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Dimensionless\Dimensionless;
use Monadial\Siphon\Unit\Dimensionless\Dimensionless\Dozen;
use Monadial\Siphon\Unit\Dimensionless\Dimensionless\Each;
use Monadial\Siphon\Unit\Dimensionless\Dimensionless\Gross;
use Monadial\Siphon\Unit\Dimensionless\Dimensionless\Percent;
use Monadial\Siphon\Unit\Dimensionless\Dimensionless\Score;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Dimensionless::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(Each::class)]
#[UsesClass(Dozen::class)]
#[UsesClass(Score::class)]
#[UsesClass(Gross::class)]
#[UsesClass(Percent::class)]
final class DimensionlessTest extends TestCase
{
    public function testIdentityConversion(): void
    {
        $quantity = new Dimensionless(BigDecimal::of('10'), Each::make());
        $result = $quantity->toEach();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('10')));
    }

    public function testEachToDozen(): void
    {
        $quantity = new Dimensionless(BigDecimal::of('24'), Each::make());
        $result = $quantity->toDozen();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('2')));
    }

    public function testDozenToEach(): void
    {
        $quantity = new Dimensionless(BigDecimal::of('3'), Dozen::make());
        $result = $quantity->toEach();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('36')));
    }

    public function testEachToScore(): void
    {
        $quantity = new Dimensionless(BigDecimal::of('60'), Each::make());
        $result = $quantity->toScore();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('3')));
    }

    public function testScoreToEach(): void
    {
        $quantity = new Dimensionless(BigDecimal::of('4'), Score::make());
        $result = $quantity->toEach();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('80')));
    }

    public function testEachToGross(): void
    {
        $quantity = new Dimensionless(BigDecimal::of('288'), Each::make());
        $result = $quantity->toGross();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('2')));
    }

    public function testGrossToEach(): void
    {
        $quantity = new Dimensionless(BigDecimal::of('2'), Gross::make());
        $result = $quantity->toEach();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('288')));
    }

    public function testEachToPercent(): void
    {
        $quantity = new Dimensionless(BigDecimal::of('1'), Each::make());
        $result = $quantity->toPercent();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('100')));
    }

    public function testPercentToEach(): void
    {
        $quantity = new Dimensionless(BigDecimal::of('50'), Percent::make());
        $result = $quantity->toEach();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.5')));
    }

    public function testDozenToGross(): void
    {
        $quantity = new Dimensionless(BigDecimal::of('12'), Dozen::make());
        $result = $quantity->toGross();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testGrossToDozen(): void
    {
        $quantity = new Dimensionless(BigDecimal::of('1'), Gross::make());
        $result = $quantity->toDozen();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('12')));
    }
}
