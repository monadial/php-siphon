<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Market;

use Monadial\Siphon\Market\Money;
use Monadial\Siphon\Market\Price;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mass\Mass;
use Monadial\Siphon\Unit\Mass\Mass\Grams;
use Monadial\Siphon\Unit\Mass\Mass\Kilograms;
use Monadial\Siphon\Unit\Mass\MassUnit;
use Monadial\Siphon\Unit\Mechanics\Energy;
use Monadial\Siphon\Unit\Mechanics\Energy\KilowattHours;
use Monadial\Siphon\Unit\Mechanics\EnergyUnit;
use Monadial\Siphon\Unit\Space\Length;
use Monadial\Siphon\Unit\Space\Length\Kilometers;
use Monadial\Siphon\Unit\Space\Length\Meters;
use Monadial\Siphon\Unit\Space\LengthUnit;
use Monadial\Siphon\UnitOfMeasure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Price::class)]
#[UsesClass(Money::class)]
#[UsesClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(Mass::class)]
#[UsesClass(MassUnit::class)]
#[UsesClass(Kilograms::class)]
#[UsesClass(Grams::class)]
#[UsesClass(Energy::class)]
#[UsesClass(EnergyUnit::class)]
#[UsesClass(KilowattHours::class)]
#[UsesClass(Length::class)]
#[UsesClass(LengthUnit::class)]
#[UsesClass(Meters::class)]
#[UsesClass(Kilometers::class)]
final class PriceTest extends TestCase
{
    public function testPricePerKilogram(): void
    {
        $price = Money::usd('5.00')->per(Mass::kilograms(1));
        $cost = $price->times(Mass::kilograms(10));

        self::assertSame('USD', $cost->currencyCode());
        self::assertSame('50.00', (string) $cost->amount());
    }

    public function testPriceWithCrossUnitQuantity(): void
    {
        // $5/kg, buy 500g
        $price = Money::usd('5.00')->per(Mass::kilograms(1));
        $cost = $price->times(Mass::grams(500));

        self::assertEqualsWithDelta(2.50, (float) (string) $cost->amount(), 0.01);
    }

    public function testPricePerKilowattHour(): void
    {
        // €0.12/kWh, consume 350 kWh
        $price = Money::eur('0.12')->per(Energy::kilowattHours(1));
        $cost = $price->times(Energy::kilowattHours(350));

        self::assertEqualsWithDelta(42.0, (float) (string) $cost->amount(), 0.01);
    }

    public function testPricePerMeter(): void
    {
        // $2/m, buy 5 km = 5000 m
        $price = Money::usd('2.00')->per(Length::meters(1));
        $cost = $price->times(Length::kilometers(5));

        self::assertEqualsWithDelta(10000.0, (float) (string) $cost->amount(), 0.01);
    }

    public function testMoneyAccessor(): void
    {
        $money = Money::usd('5.00');
        $price = $money->per(Mass::kilograms(1));

        self::assertTrue($price->money()->isEqualTo($money));
    }

    public function testQuantityAccessor(): void
    {
        $quantity = Mass::kilograms(1);
        $price = Money::usd('5.00')->per($quantity);

        self::assertInstanceOf(Mass::class, $price->quantity());
    }

    public function testToString(): void
    {
        $price = Money::usd('5.00')->per(Mass::kilograms(1));

        self::assertSame('5.00 USD/kg', (string) $price);
    }

    public function testToStringForEnergy(): void
    {
        $price = Money::eur('0.12')->per(Energy::kilowattHours(1));

        self::assertSame('0.12 EUR/kWh', (string) $price);
    }

    // ---------------------------------------------------------------
    // Functor laws
    // ---------------------------------------------------------------

    #[Group('functor')]
    public function testMapIdentity(): void
    {
        $p = Money::usd('5.00')->per(Mass::kilograms(1));

        self::assertTrue($p->map(static fn (Money $m): Money => $m)->isEqualTo($p));
    }

    #[Group('functor')]
    public function testMapComposition(): void
    {
        $p = Money::usd('10.00')->per(Mass::kilograms(1));
        $f = static fn (Money $m): Money => $m->times(2);
        $g = static fn (Money $m): Money => $m->plus(Money::usd('1.00'));

        $left = $p->map($f)->map($g);
        $right = $p->map(static fn (Money $m): Money => $g($f($m)));

        self::assertTrue($left->isEqualTo($right));
    }

    #[Group('functor')]
    public function testMapQuantityIdentity(): void
    {
        $p = Money::usd('5.00')->per(Mass::kilograms(1));

        self::assertTrue($p->mapQuantity(static fn (Mass $q): Mass => $q)->isEqualTo($p));
    }

    // ---------------------------------------------------------------
    // Bifunctor laws
    // ---------------------------------------------------------------

    #[Group('bifunctor')]
    public function testBimapIdentity(): void
    {
        $p = Money::usd('5.00')->per(Mass::kilograms(1));

        $result = $p->bimap(
            static fn (Money $m): Money => $m,
            static fn (Mass $q): Mass => $q,
        );

        self::assertTrue($result->isEqualTo($p));
    }

    // ---------------------------------------------------------------
    // Monad laws
    // ---------------------------------------------------------------

    #[Group('monad')]
    public function testFlatMapLeftIdentity(): void
    {
        $m = Money::usd('5.00');
        $q = Mass::kilograms(1);
        $f = static fn (Money $m, Mass $q): Price => new Price($m->times(2), $q);

        $left = Price::pure($m, $q)->flatMap($f);
        $right = $f($m, $q);

        self::assertTrue($left->isEqualTo($right));
    }

    #[Group('monad')]
    public function testFlatMapRightIdentity(): void
    {
        $p = Money::usd('5.00')->per(Mass::kilograms(1));

        $result = $p->flatMap(static fn (Money $m, Mass $q): Price => Price::pure($m, $q));

        self::assertTrue($result->isEqualTo($p));
    }

    #[Group('monad')]
    public function testFlatMapAssociativity(): void
    {
        $p = Money::usd('10.00')->per(Mass::kilograms(1));
        $f = static fn (Money $m, Mass $q): Price => new Price($m->times(2), $q);
        $g = static fn (Money $m, Mass $q): Price => new Price($m->plus(Money::usd('1.00')), $q);

        $left = $p->flatMap($f)->flatMap($g);
        $right = $p->flatMap(static fn (Money $m, Mass $q): Price => $f($m, $q)->flatMap($g));

        self::assertTrue($left->isEqualTo($right));
    }

    // ---------------------------------------------------------------
    // Applicative laws
    // ---------------------------------------------------------------

    #[Group('applicative')]
    public function testPureConstructsPrice(): void
    {
        $m = Money::usd('5.00');
        $q = Mass::kilograms(1);

        $p = Price::pure($m, $q);

        self::assertTrue($p->money()->isEqualTo($m));
        self::assertInstanceOf(Mass::class, $p->quantity());
    }

    #[Group('applicative')]
    public function testMap2Combines(): void
    {
        $a = Money::usd('3.00')->per(Mass::kilograms(1));
        $b = Money::usd('2.00')->per(Mass::kilograms(1));

        $result = Price::map2(
            $a,
            $b,
            static fn (Money $x, Money $y): Money => $x->plus($y),
        );

        self::assertTrue($result->money()->isEqualTo(Money::usd('5.00')));
        self::assertTrue($result->quantity()->isEqualTo(Mass::kilograms(1)));
    }

    // ---------------------------------------------------------------
    // Practical use-case tests
    // ---------------------------------------------------------------

    public function testMapAppliesDiscount(): void
    {
        $price = Money::usd('10.00')->per(Mass::kilograms(1));

        $discounted = $price->map(static fn (Money $m): Money => $m->times('0.8'));

        self::assertTrue($discounted->money()->isEqualTo(Money::usd('8.00')));
        self::assertTrue($discounted->quantity()->isEqualTo(Mass::kilograms(1)));
    }

    public function testMapQuantityConvertsUnit(): void
    {
        $price = Money::usd('5.00')->per(Mass::kilograms(1));

        $result = $price->mapQuantity(
            static fn (Mass $q): Mass => $q->scaleTo(Grams::make()),
        );

        self::assertInstanceOf(Grams::class, $result->quantity()->uom());
    }

    public function testBimapTransformsBoth(): void
    {
        $price = Money::usd('10.00')->per(Mass::kilograms(1));

        $result = $price->bimap(
            static fn (Money $m): Money => $m->times('0.8'),
            static fn (Mass $q): Mass => $q->scaleTo(Grams::make()),
        );

        self::assertTrue($result->money()->isEqualTo(Money::usd('8.00')));
        self::assertInstanceOf(Grams::class, $result->quantity()->uom());
    }

    public function testFlatMapChainsComputation(): void
    {
        $price = Money::usd('10.00')->per(Mass::kilograms(1));

        $result = $price->flatMap(
            static fn (Money $m, Mass $q): Price => new Price(
                $m->times(2)->plus(Money::usd('1.00')),
                $q,
            ),
        );

        self::assertTrue($result->money()->isEqualTo(Money::usd('21.00')));
    }

    public function testFoldExtractsString(): void
    {
        $price = Money::usd('5.00')->per(Mass::kilograms(1));

        $result = $price->fold(
            static fn (Money $m, Mass $q): string => $m->amount() . ' per ' . $q->uom()->symbol(),
        );

        self::assertSame('5.00 per kg', $result);
    }

    public function testIsEqualToReturnsTrueForEqual(): void
    {
        $a = Money::usd('5.00')->per(Mass::kilograms(1));
        $b = Money::usd('5.00')->per(Mass::kilograms(1));

        self::assertTrue($a->isEqualTo($b));
    }

    public function testIsEqualToReturnsFalseForDifferentMoney(): void
    {
        $a = Money::usd('5.00')->per(Mass::kilograms(1));
        $b = Money::usd('6.00')->per(Mass::kilograms(1));

        self::assertFalse($a->isEqualTo($b));
    }

    public function testIsEqualToReturnsFalseForDifferentQuantity(): void
    {
        $a = Money::usd('5.00')->per(Mass::kilograms(1));
        $b = Money::usd('5.00')->per(Mass::kilograms(2));

        self::assertFalse($a->isEqualTo($b));
    }
}
