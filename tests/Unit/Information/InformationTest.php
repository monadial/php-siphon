<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Information;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\BinarySystem;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Information\Information;
use Monadial\Siphon\Unit\Information\Information\Bits;
use Monadial\Siphon\Unit\Information\Information\Bytes;
use Monadial\Siphon\Unit\Information\Information\Exabytes;
use Monadial\Siphon\Unit\Information\Information\Exbibytes;
use Monadial\Siphon\Unit\Information\Information\Gibibytes;
use Monadial\Siphon\Unit\Information\Information\Gigabytes;
use Monadial\Siphon\Unit\Information\Information\Kibibytes;
use Monadial\Siphon\Unit\Information\Information\Kilobytes;
use Monadial\Siphon\Unit\Information\Information\Mebibytes;
use Monadial\Siphon\Unit\Information\Information\Megabytes;
use Monadial\Siphon\Unit\Information\Information\Pebibytes;
use Monadial\Siphon\Unit\Information\Information\Petabytes;
use Monadial\Siphon\Unit\Information\Information\Tebibytes;
use Monadial\Siphon\Unit\Information\Information\Terabytes;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Information::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(BinarySystem::class)]
#[UsesClass(Bytes::class)]
#[UsesClass(Bits::class)]
#[UsesClass(Kilobytes::class)]
#[UsesClass(Megabytes::class)]
#[UsesClass(Gigabytes::class)]
#[UsesClass(Terabytes::class)]
#[UsesClass(Petabytes::class)]
#[UsesClass(Exabytes::class)]
#[UsesClass(Kibibytes::class)]
#[UsesClass(Mebibytes::class)]
#[UsesClass(Gibibytes::class)]
#[UsesClass(Tebibytes::class)]
#[UsesClass(Pebibytes::class)]
#[UsesClass(Exbibytes::class)]
final class InformationTest extends TestCase
{
    public function testIdentityConversion(): void
    {
        $info = new Information(BigDecimal::of('1024'), Bytes::make());
        $result = $info->toBytes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1024')));
    }

    public function testBytesToBits(): void
    {
        // 1 byte = 8 bits
        $info = new Information(BigDecimal::of('1'), Bytes::make());
        $result = $info->toBits();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('8')));
    }

    public function testBitsToBytes(): void
    {
        // 8 bits = 1 byte
        $info = new Information(BigDecimal::of('8'), Bits::make());
        $result = $info->toBytes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testBytesToKilobytes(): void
    {
        // 1000 bytes = 1 KB
        $info = new Information(BigDecimal::of('1000'), Bytes::make());
        $result = $info->toKilobytes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testKilobytesToBytes(): void
    {
        // 1 KB = 1000 bytes
        $info = new Information(BigDecimal::of('1'), Kilobytes::make());
        $result = $info->toBytes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testBytesToMegabytes(): void
    {
        // 1000000 bytes = 1 MB
        $info = new Information(BigDecimal::of('1000000'), Bytes::make());
        $result = $info->toMegabytes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testBytesToGigabytes(): void
    {
        // 1000000000 bytes = 1 GB
        $info = new Information(BigDecimal::of('1000000000'), Bytes::make());
        $result = $info->toGigabytes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testBytesToTerabytes(): void
    {
        // 1000000000000 bytes = 1 TB
        $info = new Information(BigDecimal::of('1000000000000'), Bytes::make());
        $result = $info->toTerabytes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testBytesToPetabytes(): void
    {
        // 1000000000000000 bytes = 1 PB
        $info = new Information(BigDecimal::of('1000000000000000'), Bytes::make());
        $result = $info->toPetabytes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testBytesToExabytes(): void
    {
        // 1000000000000000000 bytes = 1 EB
        $info = new Information(BigDecimal::of('1000000000000000000'), Bytes::make());
        $result = $info->toExabytes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testBytesToKibibytes(): void
    {
        // 1024 bytes = 1 KiB
        $info = new Information(BigDecimal::of('1024'), Bytes::make());
        $result = $info->toKibibytes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testKibibytesToBytes(): void
    {
        // 1 KiB = 1024 bytes
        $info = new Information(BigDecimal::of('1'), Kibibytes::make());
        $result = $info->toBytes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1024')));
    }

    public function testBytesToMebibytes(): void
    {
        // 1048576 bytes = 1 MiB
        $info = new Information(BigDecimal::of('1048576'), Bytes::make());
        $result = $info->toMebibytes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testBytesToGibibytes(): void
    {
        // 1073741824 bytes = 1 GiB
        $info = new Information(BigDecimal::of('1073741824'), Bytes::make());
        $result = $info->toGibibytes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testBytesToTebibytes(): void
    {
        // 1099511627776 bytes = 1 TiB
        $info = new Information(BigDecimal::of('1099511627776'), Bytes::make());
        $result = $info->toTebibytes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testBytesToPebibytes(): void
    {
        // 1125899906842624 bytes = 1 PiB
        $info = new Information(BigDecimal::of('1125899906842624'), Bytes::make());
        $result = $info->toPebibytes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testBytesToExbibytes(): void
    {
        // 1152921504606846976 bytes = 1 EiB
        $info = new Information(BigDecimal::of('1152921504606846976'), Bytes::make());
        $result = $info->toExbibytes();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1')));
    }

    public function testKilobytesToKibibytes(): void
    {
        // 1 KB (1000 bytes) in KiB = 1000/1024 ≈ 0.9765625
        $info = new Information(BigDecimal::of('1'), Kilobytes::make());
        $result = $info->toKibibytes();

        self::assertEqualsWithDelta(0.9765625, (float) (string) $result->value(), 0.0001);
    }

    public function testGigabytesToGibibytes(): void
    {
        // 1 GB (1e9 bytes) in GiB = 1e9/1073741824 ≈ 0.9313
        $info = new Information(BigDecimal::of('1'), Gigabytes::make());
        $result = $info->toGibibytes();

        self::assertEqualsWithDelta(0.9313, (float) (string) $result->value(), 0.001);
    }

    public function testRoundTripBytesToKibibytesAndBack(): void
    {
        $original = new Information(BigDecimal::of('2048'), Bytes::make());
        $converted = $original->toKibibytes();
        $roundTrip = $converted->toBytes();

        self::assertTrue($roundTrip->value()->isEqualTo(BigDecimal::of('2048')));
    }
}
