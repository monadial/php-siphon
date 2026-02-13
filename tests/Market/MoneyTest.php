<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Market;

use Brick\Math\BigDecimal;
use Brick\Money\Currency;
use Monadial\Siphon\Exception\InvalidArgument;
use Monadial\Siphon\Exception\ParseFailure;
use Monadial\Siphon\Market\ExchangeRate;
use Monadial\Siphon\Market\Money;
use Monadial\Siphon\Market\Price;
use Monadial\Siphon\Unit\Mass\Mass;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Money::class)]
#[UsesClass(ExchangeRate::class)]
#[UsesClass(Price::class)]
final class MoneyTest extends TestCase
{
    // ---------------------------------------------------------------
    // Construction
    // ---------------------------------------------------------------

    public function testOfWithString(): void
    {
        $money = Money::of('50.00', 'USD');

        self::assertSame('50.00', (string) $money->amount());
        self::assertSame('USD', $money->currencyCode());
    }

    public function testOfWithCurrencyObject(): void
    {
        $money = Money::of(100, Currency::of('EUR'));

        self::assertSame('100.00', (string) $money->amount());
        self::assertSame('EUR', $money->currencyCode());
    }

    public function testOfMinor(): void
    {
        $money = Money::ofMinor(1234, 'USD');

        self::assertSame('12.34', (string) $money->amount());
    }

    public function testZero(): void
    {
        $money = Money::zero('EUR');

        self::assertTrue($money->isZero());
        self::assertSame('EUR', $money->currencyCode());
    }

    /** @throws ParseFailure */
    public function testParse(): void
    {
        $a = Money::parse('50.00 USD');
        self::assertSame('50.00', (string) $a->amount());
        self::assertSame('USD', $a->currencyCode());

        $b = Money::parse('EUR 10.50');
        self::assertSame('10.50', (string) $b->amount());
        self::assertSame('EUR', $b->currencyCode());
    }

    // ---------------------------------------------------------------
    // Currency-specific factories
    // ---------------------------------------------------------------

    public function testUsdFactory(): void
    {
        $money = Money::usd('49.99');
        self::assertSame('USD', $money->currencyCode());
        self::assertSame('49.99', (string) $money->amount());
    }

    public function testEurFactory(): void
    {
        $money = Money::eur(100);
        self::assertSame('EUR', $money->currencyCode());
    }

    public function testGbpFactory(): void
    {
        $money = Money::gbp('9.99');
        self::assertSame('GBP', $money->currencyCode());
    }

    public function testJpyFactory(): void
    {
        $money = Money::jpy(1000);
        self::assertSame('JPY', $money->currencyCode());
        // JPY has 0 fraction digits
        self::assertSame('1000', (string) $money->amount());
    }

    public function testChfFactory(): void
    {
        $money = Money::chf('25.50');
        self::assertSame('CHF', $money->currencyCode());
    }

    public function testCzkFactory(): void
    {
        $money = Money::czk(500);
        self::assertSame('CZK', $money->currencyCode());
    }

    // ---------------------------------------------------------------
    // Arithmetic
    // ---------------------------------------------------------------

    public function testPlus(): void
    {
        $a = Money::usd('10.00');
        $b = Money::usd('5.50');
        $result = $a->plus($b);

        self::assertSame('15.50', (string) $result->amount());
    }

    public function testMinus(): void
    {
        $a = Money::usd('10.00');
        $b = Money::usd('3.25');
        $result = $a->minus($b);

        self::assertSame('6.75', (string) $result->amount());
    }

    public function testTimes(): void
    {
        $money = Money::usd('10.00');
        $result = $money->times(3);

        self::assertSame('30.00', (string) $result->amount());
    }

    public function testTimesDecimal(): void
    {
        $money = Money::usd('10.00');
        $result = $money->times('1.5');

        self::assertSame('15.00', (string) $result->amount());
    }

    public function testDividedBy(): void
    {
        $money = Money::usd('10.00');
        $result = $money->dividedBy(4);

        self::assertSame('2.50', (string) $result->amount());
    }

    public function testNegate(): void
    {
        $money = Money::usd('42.00');
        $result = $money->negate();

        self::assertSame('-42.00', (string) $result->amount());
    }

    public function testAbs(): void
    {
        $money = Money::usd('-42.00');
        $result = $money->abs();

        self::assertSame('42.00', (string) $result->amount());
    }

    // ---------------------------------------------------------------
    // Comparisons
    // ---------------------------------------------------------------

    public function testIsEqualTo(): void
    {
        $a = Money::usd('10.00');
        $b = Money::usd('10.00');
        $c = Money::usd('20.00');

        self::assertTrue($a->isEqualTo($b));
        self::assertFalse($a->isEqualTo($c));
    }

    public function testIsGreaterThan(): void
    {
        $a = Money::usd('20.00');
        $b = Money::usd('10.00');

        self::assertTrue($a->isGreaterThan($b));
        self::assertFalse($b->isGreaterThan($a));
    }

    public function testIsLessThan(): void
    {
        $a = Money::usd('5.00');
        $b = Money::usd('10.00');

        self::assertTrue($a->isLessThan($b));
        self::assertFalse($b->isLessThan($a));
    }

    public function testIsGreaterThanOrEqualTo(): void
    {
        $a = Money::usd('10.00');
        $b = Money::usd('10.00');
        $c = Money::usd('5.00');

        self::assertTrue($a->isGreaterThanOrEqualTo($b));
        self::assertTrue($a->isGreaterThanOrEqualTo($c));
        self::assertFalse($c->isGreaterThanOrEqualTo($a));
    }

    public function testIsLessThanOrEqualTo(): void
    {
        $a = Money::usd('10.00');
        $b = Money::usd('10.00');
        $c = Money::usd('20.00');

        self::assertTrue($a->isLessThanOrEqualTo($b));
        self::assertTrue($a->isLessThanOrEqualTo($c));
        self::assertFalse($c->isLessThanOrEqualTo($a));
    }

    public function testIsZero(): void
    {
        self::assertTrue(Money::usd(0)->isZero());
        self::assertFalse(Money::usd(1)->isZero());
    }

    public function testIsPositive(): void
    {
        self::assertTrue(Money::usd(10)->isPositive());
        self::assertFalse(Money::usd(-10)->isPositive());
    }

    public function testIsNegative(): void
    {
        self::assertTrue(Money::usd(-10)->isNegative());
        self::assertFalse(Money::usd(10)->isNegative());
    }

    // ---------------------------------------------------------------
    // Conversion
    // ---------------------------------------------------------------

    /** @throws InvalidArgument */
    public function testConvertTo(): void
    {
        $usd = Money::usd('100.00');
        $rate = new ExchangeRate('USD', 'EUR', '0.91');
        $eur = $usd->convertTo('EUR', $rate);

        self::assertSame('EUR', $eur->currencyCode());
        self::assertSame('91.00', (string) $eur->amount());
    }

    /** @throws InvalidArgument */
    public function testConvertToWithMismatchedCurrencyThrows(): void
    {
        $usd = Money::usd('100.00');
        $rate = new ExchangeRate('USD', 'EUR', '0.91');

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Currency GBP does not match exchange rate target EUR');

        $usd->convertTo('GBP', $rate);
    }

    // ---------------------------------------------------------------
    // Allocation
    // ---------------------------------------------------------------

    public function testSplit(): void
    {
        $money = Money::usd('100.00');
        $parts = $money->split(3);

        self::assertCount(3, $parts);

        $total = Money::usd(0);
        foreach ($parts as $part) {
            $total = $total->plus($part);
        }
        self::assertTrue($total->isEqualTo($money));
    }

    public function testAllocate(): void
    {
        $money = Money::usd('100.00');
        $parts = $money->allocate(1, 1, 2);

        self::assertCount(3, $parts);

        $total = Money::usd(0);
        foreach ($parts as $part) {
            $total = $total->plus($part);
        }
        self::assertTrue($total->isEqualTo($money));
    }

    // ---------------------------------------------------------------
    // Access
    // ---------------------------------------------------------------

    public function testAmount(): void
    {
        $money = Money::usd('42.50');
        self::assertInstanceOf(BigDecimal::class, $money->amount());
        self::assertSame('42.50', (string) $money->amount());
    }

    public function testCurrency(): void
    {
        $money = Money::eur(10);
        self::assertInstanceOf(Currency::class, $money->currency());
        self::assertSame('EUR', $money->currency()->getCurrencyCode());
    }

    public function testToString(): void
    {
        $money = Money::usd('50.00');
        self::assertSame('50.00 USD', (string) $money);
    }

    // ---------------------------------------------------------------
    // Price creation
    // ---------------------------------------------------------------

    public function testPerCreatesPrice(): void
    {
        $money = Money::usd('5.00');
        $quantity = Mass::kilograms(1);
        $price = $money->per($quantity);

        self::assertInstanceOf(Price::class, $price);
    }

    // ---------------------------------------------------------------
    // Immutability
    // ---------------------------------------------------------------

    public function testImmutability(): void
    {
        $original = Money::usd('100.00');
        $original->plus(Money::usd('50.00'));
        $original->times(2);
        $original->negate();

        self::assertSame('100.00', (string) $original->amount());
    }
}
