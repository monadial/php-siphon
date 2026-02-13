<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\Substance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Substance\AmountOfSubstance;
use Monadial\Siphon\Unit\Substance\AmountOfSubstance\Kilomoles;
use Monadial\Siphon\Unit\Substance\AmountOfSubstance\Micromoles;
use Monadial\Siphon\Unit\Substance\AmountOfSubstance\Millimoles;
use Monadial\Siphon\Unit\Substance\AmountOfSubstance\Moles;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AmountOfSubstance::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(Micromoles::class)]
#[UsesClass(Millimoles::class)]
#[UsesClass(Moles::class)]
#[UsesClass(Kilomoles::class)]
final class AmountOfSubstanceTest extends TestCase
{
    public function testIdentityConversion(): void
    {
        $amount = new AmountOfSubstance(BigDecimal::of('2.5'), Moles::make());
        $result = $amount->toMoles();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('2.5')));
    }

    public function testMolesToMillimoles(): void
    {
        $amount = new AmountOfSubstance(BigDecimal::of('1'), Moles::make());
        $result = $amount->toMillimoles();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000')));
    }

    public function testMillimolesToMoles(): void
    {
        $amount = new AmountOfSubstance(BigDecimal::of('500'), Millimoles::make());
        $result = $amount->toMoles();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('0.5')));
    }

    public function testMolesToMicromoles(): void
    {
        $amount = new AmountOfSubstance(BigDecimal::of('1'), Moles::make());
        $result = $amount->toMicromoles();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000')));
    }

    public function testMolesToKilomoles(): void
    {
        $amount = new AmountOfSubstance(BigDecimal::of('5000'), Moles::make());
        $result = $amount->toKilomoles();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('5')));
    }

    public function testKilomolesToMicromoles(): void
    {
        $amount = new AmountOfSubstance(BigDecimal::of('1'), Kilomoles::make());
        $result = $amount->toMicromoles();

        self::assertTrue($result->value()->isEqualTo(BigDecimal::of('1000000000')));
    }

    // ---------------------------------------------------------------
    // Typed factory methods (plural forms)
    // ---------------------------------------------------------------

    public function testKilomolesFactory(): void
    {
        self::assertInstanceOf(Kilomoles::class, AmountOfSubstance::kilomoles(1)->uom());
    }

    public function testMicromolesFactory(): void
    {
        self::assertInstanceOf(Micromoles::class, AmountOfSubstance::micromoles(1)->uom());
    }

    public function testMillimolesFactory(): void
    {
        self::assertInstanceOf(Millimoles::class, AmountOfSubstance::millimoles(1)->uom());
    }

    public function testMolesFactory(): void
    {
        self::assertInstanceOf(Moles::class, AmountOfSubstance::moles(1)->uom());
    }

    // ---------------------------------------------------------------
    // Typed factory methods (singular forms)
    // ---------------------------------------------------------------

    public function testKilomoleFactory(): void
    {
        self::assertInstanceOf(Kilomoles::class, AmountOfSubstance::kilomole(1)->uom());
    }

    public function testMicromoleFactory(): void
    {
        self::assertInstanceOf(Micromoles::class, AmountOfSubstance::micromole(1)->uom());
    }

    public function testMillimoleFactory(): void
    {
        self::assertInstanceOf(Millimoles::class, AmountOfSubstance::millimole(1)->uom());
    }

    public function testMoleFactory(): void
    {
        self::assertInstanceOf(Moles::class, AmountOfSubstance::mole(1)->uom());
    }
}
