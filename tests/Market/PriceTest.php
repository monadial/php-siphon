<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Market;

use Monadial\Siphon\Market\Money;
use Monadial\Siphon\Market\Price;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\UnitOfMeasure;
use Monadial\Siphon\Unit\Mass\Mass;
use Monadial\Siphon\Unit\Mass\MassUnit;
use Monadial\Siphon\Unit\Mass\Mass\Grams;
use Monadial\Siphon\Unit\Mass\Mass\Kilograms;
use Monadial\Siphon\Unit\Mechanics\Energy;
use Monadial\Siphon\Unit\Mechanics\EnergyUnit;
use Monadial\Siphon\Unit\Mechanics\Energy\KilowattHours;
use Monadial\Siphon\Unit\Space\Length;
use Monadial\Siphon\Unit\Space\LengthUnit;
use Monadial\Siphon\Unit\Space\Length\Kilometers;
use Monadial\Siphon\Unit\Space\Length\Meters;
use PHPUnit\Framework\Attributes\CoversClass;
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
}
