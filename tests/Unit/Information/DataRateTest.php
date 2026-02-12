<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Information;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Information\DataRate;
use Monadial\Siphon\Unit\Information\DataRate\BitsPerSecond;
use Monadial\Siphon\Unit\Information\DataRate\BytesPerSecond;
use Monadial\Siphon\Unit\Information\DataRate\GigabitsPerSecond;
use Monadial\Siphon\Unit\Information\DataRate\GigabytesPerSecond;
use Monadial\Siphon\Unit\Information\DataRate\KilobitsPerSecond;
use Monadial\Siphon\Unit\Information\DataRate\KilobytesPerSecond;
use Monadial\Siphon\Unit\Information\DataRate\MegabitsPerSecond;
use Monadial\Siphon\Unit\Information\DataRate\MegabytesPerSecond;
use Monadial\Siphon\Unit\Information\DataRate\TerabytesPerSecond;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DataRate::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(BytesPerSecond::class)]
#[UsesClass(KilobytesPerSecond::class)]
#[UsesClass(MegabytesPerSecond::class)]
#[UsesClass(GigabytesPerSecond::class)]
#[UsesClass(TerabytesPerSecond::class)]
#[UsesClass(BitsPerSecond::class)]
#[UsesClass(KilobitsPerSecond::class)]
#[UsesClass(MegabitsPerSecond::class)]
#[UsesClass(GigabitsPerSecond::class)]
final class DataRateTest extends TestCase
{
    public function testIdentityConversion(): void
    {
        $rate = new DataRate(BigDecimal::of('1000'), BytesPerSecond::make());
        $result = $rate->toBytesPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testBytesPerSecondToKilobytesPerSecond(): void
    {
        // 1000 B/s = 1 KB/s
        $rate = new DataRate(BigDecimal::of('1000'), BytesPerSecond::make());
        $result = $rate->toKilobytesPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testKilobytesPerSecondToBytesPerSecond(): void
    {
        // 1 KB/s = 1000 B/s
        $rate = new DataRate(BigDecimal::of('1'), KilobytesPerSecond::make());
        $result = $rate->toBytesPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testBytesPerSecondToMegabytesPerSecond(): void
    {
        // 1000000 B/s = 1 MB/s
        $rate = new DataRate(BigDecimal::of('1000000'), BytesPerSecond::make());
        $result = $rate->toMegabytesPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testBytesPerSecondToGigabytesPerSecond(): void
    {
        // 1000000000 B/s = 1 GB/s
        $rate = new DataRate(BigDecimal::of('1000000000'), BytesPerSecond::make());
        $result = $rate->toGigabytesPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testBytesPerSecondToTerabytesPerSecond(): void
    {
        // 1000000000000 B/s = 1 TB/s
        $rate = new DataRate(BigDecimal::of('1000000000000'), BytesPerSecond::make());
        $result = $rate->toTerabytesPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testBytesPerSecondToBitsPerSecond(): void
    {
        // 1 B/s = 8 bps
        $rate = new DataRate(BigDecimal::of('1'), BytesPerSecond::make());
        $result = $rate->toBitsPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('8')));
    }

    public function testBitsPerSecondToBytesPerSecond(): void
    {
        // 8 bps = 1 B/s
        $rate = new DataRate(BigDecimal::of('8'), BitsPerSecond::make());
        $result = $rate->toBytesPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testKilobitsPerSecondToBytesPerSecond(): void
    {
        // 1 Kbps = 125 B/s
        $rate = new DataRate(BigDecimal::of('1'), KilobitsPerSecond::make());
        $result = $rate->toBytesPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('125')));
    }

    public function testMegabitsPerSecondToBytesPerSecond(): void
    {
        // 1 Mbps = 125000 B/s
        $rate = new DataRate(BigDecimal::of('1'), MegabitsPerSecond::make());
        $result = $rate->toBytesPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('125000')));
    }

    public function testGigabitsPerSecondToBytesPerSecond(): void
    {
        // 1 Gbps = 125000000 B/s
        $rate = new DataRate(BigDecimal::of('1'), GigabitsPerSecond::make());
        $result = $rate->toBytesPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('125000000')));
    }

    public function testMegabitsPerSecondToMegabytesPerSecond(): void
    {
        // 8 Mbps = 1 MB/s
        $rate = new DataRate(BigDecimal::of('8'), MegabitsPerSecond::make());
        $result = $rate->toMegabytesPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testGigabitsPerSecondToMegabytesPerSecond(): void
    {
        // 1 Gbps = 125 MB/s
        $rate = new DataRate(BigDecimal::of('1'), GigabitsPerSecond::make());
        $result = $rate->toMegabytesPerSecond();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('125')));
    }

    public function testRoundTripBytesToKilobitsAndBack(): void
    {
        $original = new DataRate(BigDecimal::of('1000'), BytesPerSecond::make());
        $converted = $original->toKilobitsPerSecond();
        $roundTrip = $converted->toBytesPerSecond();

        self::assertTrue($roundTrip->value()->isEqualTo(BigDecimal::of('1000')));
    }
}
