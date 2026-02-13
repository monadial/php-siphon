<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\System;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(MetricSystem::class)]
final class MetricSystemTest extends TestCase
{
    /**
     * @return array<string, array{MetricSystem, string}>
     */
    public static function prefixFactorProvider(): array
    {
        return [
            'BASE' => [MetricSystem::BASE, '1'],
            'CENTI' => [MetricSystem::CENTI, '0.01'],
            'DECA' => [MetricSystem::DECA, '10'],
            'DECI' => [MetricSystem::DECI, '0.1'],
            'GIGA' => [MetricSystem::GIGA, '1000000000'],
            'HECTO' => [MetricSystem::HECTO, '100'],
            'KILO' => [MetricSystem::KILO, '1000'],
            'MEGA' => [MetricSystem::MEGA, '1000000'],
            'MICRO' => [MetricSystem::MICRO, '0.000001'],
            'MILLI' => [MetricSystem::MILLI, '0.001'],
            'NANO' => [MetricSystem::NANO, '0.000000001'],
            'TERA' => [MetricSystem::TERA, '1000000000000'],
        ];
    }

    /**
     * @return array<string, array{MetricSystem, string}>
     */
    public static function extendedPrefixFactorProvider(): array
    {
        return [
            'ATTO' => [MetricSystem::ATTO, '0.000000000000000001'],
            'EXA' => [MetricSystem::EXA, '1000000000000000000'],
            'FEMTO' => [MetricSystem::FEMTO, '0.000000000000001'],
            'PETA' => [MetricSystem::PETA, '1000000000000000'],
            'PICO' => [MetricSystem::PICO, '0.000000000001'],
        ];
    }

    #[DataProvider('prefixFactorProvider')]
    public function testFactorReturnsExpectedValue(MetricSystem $prefix, string $expected): void
    {
        self::assertTrue($prefix->factor()->isEqualTo(BigDecimal::of($expected)));
    }

    public function testFactorReturnsBigDecimal(): void
    {
        self::assertInstanceOf(BigDecimal::class, MetricSystem::BASE->factor());
    }

    public function testAllCasesHaveFactor(): void
    {
        foreach (MetricSystem::cases() as $case) {
            self::assertInstanceOf(BigDecimal::class, $case->factor());
        }
    }

    #[DataProvider('extendedPrefixFactorProvider')]
    public function testExtendedPrefixFactors(MetricSystem $prefix, string $expected): void
    {
        self::assertTrue($prefix->factor()->isEqualTo(BigDecimal::of($expected)));
    }

    public function testBaseFactorIsOne(): void
    {
        self::assertTrue(MetricSystem::BASE->factor()->isEqualTo(BigDecimal::one()));
    }

    public function testKiloIsThousandTimesBase(): void
    {
        $ratio = MetricSystem::KILO->factor()->dividedBy(MetricSystem::BASE->factor());
        self::assertTrue($ratio->isEqualTo(BigDecimal::of('1000')));
    }

    public function testMilliIsOneThousandthOfBase(): void
    {
        $product = MetricSystem::MILLI->factor()->multipliedBy(BigDecimal::of('1000'));
        self::assertTrue($product->isEqualTo(MetricSystem::BASE->factor()));
    }
}
