<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\System;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\BinarySystem;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(BinarySystem::class)]
final class BinarySystemTest extends TestCase
{
    /**
     * @return array<string, array{BinarySystem, string}>
     */
    public static function prefixFactorProvider(): array
    {
        return [
            'BYTE' => [BinarySystem::BYTE, '1'],
            'KIBI' => [BinarySystem::KIBI, '1024'],
            'MEBI' => [BinarySystem::MEBI, '1048576'],
            'GIBI' => [BinarySystem::GIBI, '1073741824'],
            'TEBI' => [BinarySystem::TEBI, '1099511627776'],
            'PEBI' => [BinarySystem::PEBI, '1125899906842624'],
            'EXBI' => [BinarySystem::EXBI, '1152921504606846976'],
        ];
    }

    #[DataProvider('prefixFactorProvider')]
    public function testFactorReturnsExpectedValue(BinarySystem $prefix, string $expected): void
    {
        self::assertTrue($prefix->factor()->isEqualTo(BigDecimal::of($expected)));
    }

    public function testFactorReturnsBigDecimal(): void
    {
        self::assertInstanceOf(BigDecimal::class, BinarySystem::BYTE->factor());
    }

    public function testAllCasesHaveFactor(): void
    {
        foreach (BinarySystem::cases() as $case) {
            self::assertInstanceOf(BigDecimal::class, $case->factor());
        }
    }

    public function testKibiIs1024TimesBase(): void
    {
        $ratio = BinarySystem::KIBI->factor()->dividedBy(BinarySystem::BYTE->factor());
        self::assertTrue($ratio->isEqualTo(BigDecimal::of('1024')));
    }

    public function testMebiIs1024TimesKibi(): void
    {
        $ratio = BinarySystem::MEBI->factor()->dividedBy(BinarySystem::KIBI->factor());
        self::assertTrue($ratio->isEqualTo(BigDecimal::of('1024')));
    }
}
