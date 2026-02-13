<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Time;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Time\Frequency;
use Monadial\Siphon\Unit\Time\Frequency\Gigahertz;
use Monadial\Siphon\Unit\Time\Frequency\Hertz;
use Monadial\Siphon\Unit\Time\Frequency\Kilohertz;
use Monadial\Siphon\Unit\Time\Frequency\Megahertz;
use Monadial\Siphon\Unit\Time\Frequency\RevolutionsPerMinute;
use Monadial\Siphon\Unit\Time\Frequency\Terahertz;
use Monadial\Siphon\Unit\Time\FrequencyUnit;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Frequency::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(FrequencyUnit::class)]
#[UsesClass(Hertz::class)]
#[UsesClass(Kilohertz::class)]
#[UsesClass(Megahertz::class)]
#[UsesClass(Gigahertz::class)]
#[UsesClass(Terahertz::class)]
#[UsesClass(RevolutionsPerMinute::class)]
final class FrequencyTest extends TestCase
{
    public function testIdentityConversion(): void
    {
        $frequency = new Frequency(BigDecimal::of('100'), Hertz::make());
        $result = $frequency->toHertz();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('100')));
    }

    public function testGigahertzToMegahertz(): void
    {
        $frequency = new Frequency(BigDecimal::of('1'), Gigahertz::make());
        $result = $frequency->toMegahertz();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testMegahertzToKilohertz(): void
    {
        $frequency = new Frequency(BigDecimal::of('1'), Megahertz::make());
        $result = $frequency->toKilohertz();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testKilohertzToHertz(): void
    {
        $frequency = new Frequency(BigDecimal::of('1'), Kilohertz::make());
        $result = $frequency->toHertz();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testTerahertzToMegahertz(): void
    {
        $frequency = new Frequency(BigDecimal::of('1'), Terahertz::make());
        $result = $frequency->toMegahertz();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    public function testGigahertzToMegahertzFractional(): void
    {
        $frequency = new Frequency(BigDecimal::of('2.4'), Gigahertz::make());
        $result = $frequency->toMegahertz();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('2400')));
    }

    public function testHertzToKilohertz(): void
    {
        $frequency = new Frequency(BigDecimal::of('5000'), Hertz::make());
        $result = $frequency->toKilohertz();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5')));
    }

    public function testMegahertzToHertz(): void
    {
        $frequency = new Frequency(BigDecimal::of('1'), Megahertz::make());
        $result = $frequency->toHertz();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    public function testTerahertzToGigahertz(): void
    {
        $frequency = new Frequency(BigDecimal::of('1'), Terahertz::make());
        $result = $frequency->toGigahertz();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testKilohertzToMegahertz(): void
    {
        $frequency = new Frequency(BigDecimal::of('2500'), Kilohertz::make());
        $result = $frequency->toMegahertz();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('2.5')));
    }

    // ---------------------------------------------------------------
    // Revolutions per minute conversions
    // ---------------------------------------------------------------

    public function testHertzToRevolutionsPerMinute(): void
    {
        $frequency = new Frequency(BigDecimal::of('1'), Hertz::make());
        $result = $frequency->toRevolutionsPerMinute();

        self::assertEqualsWithDelta(60.0, (float) (string) $result->value(), 0.001);
        self::assertInstanceOf(RevolutionsPerMinute::class, $result->uom());
    }

    public function testRevolutionsPerMinuteToHertz(): void
    {
        $frequency = new Frequency(BigDecimal::of('60'), RevolutionsPerMinute::make());
        $result = $frequency->toHertz();

        self::assertEqualsWithDelta(1.0, (float) (string) $result->value(), 0.001);
    }

    public function testRevolutionsPerMinuteToHertzLargeValue(): void
    {
        $frequency = new Frequency(BigDecimal::of('3600'), RevolutionsPerMinute::make());
        $result = $frequency->toHertz();

        self::assertEqualsWithDelta(60.0, (float) (string) $result->value(), 0.001);
    }

    public function testKilohertzToRevolutionsPerMinute(): void
    {
        $frequency = new Frequency(BigDecimal::of('1'), Kilohertz::make());
        $result = $frequency->toRevolutionsPerMinute();

        self::assertEqualsWithDelta(60000.0, (float) (string) $result->value(), 1.0);
    }

    // ---------------------------------------------------------------
    // RPM identity conversion
    // ---------------------------------------------------------------

    public function testIdentityConversionRevolutionsPerMinute(): void
    {
        $frequency = new Frequency(BigDecimal::of('7200'), RevolutionsPerMinute::make());
        $result = $frequency->toRevolutionsPerMinute();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('7200')));
        self::assertInstanceOf(RevolutionsPerMinute::class, $result->uom());
    }

    // ---------------------------------------------------------------
    // RPM round-trip conversion
    // ---------------------------------------------------------------

    public function testRoundTripHertzToRpmAndBack(): void
    {
        $original = new Frequency(BigDecimal::of('50'), Hertz::make());
        $converted = $original->toRevolutionsPerMinute();
        $roundTrip = $converted->toHertz();

        self::assertEqualsWithDelta(50.0, (float) (string) $roundTrip->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // Factory method tests
    // ---------------------------------------------------------------

    public function testFactoryGigahertz(): void
    {
        $q = Frequency::gigahertz(1);
        self::assertInstanceOf(Gigahertz::class, $q->uom());
    }

    public function testFactoryHertz(): void
    {
        $q = Frequency::hertz(1);
        self::assertInstanceOf(Hertz::class, $q->uom());
    }

    public function testFactoryKilohertz(): void
    {
        $q = Frequency::kilohertz(1);
        self::assertInstanceOf(Kilohertz::class, $q->uom());
    }

    public function testFactoryMegahertz(): void
    {
        $q = Frequency::megahertz(1);
        self::assertInstanceOf(Megahertz::class, $q->uom());
    }

    public function testFactoryRevolutionsPerMinute(): void
    {
        $q = Frequency::revolutionsPerMinute(1);
        self::assertInstanceOf(RevolutionsPerMinute::class, $q->uom());
    }

    public function testFactoryTerahertz(): void
    {
        $q = Frequency::terahertz(1);
        self::assertInstanceOf(Terahertz::class, $q->uom());
    }

    // ---------------------------------------------------------------
    // Conversion method tests
    // ---------------------------------------------------------------

    public function testToHertz(): void
    {
        $result = Frequency::kilohertz(1)->toHertz();
        self::assertInstanceOf(Hertz::class, $result->uom());
    }

    public function testToKilohertz(): void
    {
        $result = Frequency::hertz(1000)->toKilohertz();
        self::assertInstanceOf(Kilohertz::class, $result->uom());
    }

    public function testToMegahertz(): void
    {
        $result = Frequency::hertz(1000000)->toMegahertz();
        self::assertInstanceOf(Megahertz::class, $result->uom());
    }

    public function testToGigahertz(): void
    {
        $result = Frequency::megahertz(1000)->toGigahertz();
        self::assertInstanceOf(Gigahertz::class, $result->uom());
    }

    public function testToTerahertz(): void
    {
        $result = Frequency::gigahertz(1000)->toTerahertz();
        self::assertInstanceOf(Terahertz::class, $result->uom());
    }

    public function testToRevolutionsPerMinute(): void
    {
        $result = Frequency::hertz(1)->toRevolutionsPerMinute();
        self::assertInstanceOf(RevolutionsPerMinute::class, $result->uom());
    }
}
