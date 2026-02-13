<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\CrossDimensional;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Information\DataRate;
use Monadial\Siphon\Unit\Information\DataRate\BytesPerSecond;
use Monadial\Siphon\Unit\Information\DataRateUnit;
use Monadial\Siphon\Unit\Information\Information;
use Monadial\Siphon\Unit\Information\Information\Bytes;
use Monadial\Siphon\Unit\Information\InformationUnit;
use Monadial\Siphon\Unit\Time\Time;
use Monadial\Siphon\Unit\Time\Time\Seconds;
use Monadial\Siphon\Unit\Time\TimeUnit;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Information::class)]
#[CoversClass(DataRate::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(InformationUnit::class)]
#[UsesClass(DataRateUnit::class)]
#[UsesClass(TimeUnit::class)]
#[UsesClass(Bytes::class)]
#[UsesClass(BytesPerSecond::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(Time::class)]
final class InformationTest extends TestCase
{
    // ---------------------------------------------------------------
    // rate = data / time (Information / Time = DataRate)
    // ---------------------------------------------------------------

    public function testInformationDividedByTimeGivesDataRate(): void
    {
        // 1000 B / 10 s = 100 B/s
        $data = Information::bytes(1000);
        $time = Time::seconds(10);
        $rate = $data->dividedByTime($time);

        self::assertInstanceOf(DataRate::class, $rate);
        self::assertInstanceOf(BytesPerSecond::class, $rate->uom());
        self::assertEqualsWithDelta(100.0, (float) (string) $rate->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // time = data / rate (Information / DataRate = Time)
    // ---------------------------------------------------------------

    public function testInformationDividedByDataRateGivesTime(): void
    {
        // 1000 B / 100 B/s = 10 s
        $data = Information::bytes(1000);
        $rate = DataRate::bytesPerSecond(100);
        $time = $data->dividedByDataRate($rate);

        self::assertInstanceOf(Time::class, $time);
        self::assertInstanceOf(Seconds::class, $time->uom());
        self::assertEqualsWithDelta(10.0, (float) (string) $time->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // data = rate × time (DataRate × Time = Information)
    // ---------------------------------------------------------------

    public function testDataRateTimesTimeGivesInformation(): void
    {
        // 100 B/s × 10 s = 1000 B
        $rate = DataRate::bytesPerSecond(100);
        $time = Time::seconds(10);
        $data = $rate->timesTime($time);

        self::assertInstanceOf(Information::class, $data);
        self::assertInstanceOf(Bytes::class, $data->uom());
        self::assertEqualsWithDelta(1000.0, (float) (string) $data->value(), 0.0001);
    }
}
