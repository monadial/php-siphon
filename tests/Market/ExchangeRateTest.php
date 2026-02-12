<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Market;

use LogicException;
use Monadial\Siphon\Market\ExchangeRate;
use Monadial\Siphon\Market\Money;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ExchangeRate::class)]
#[UsesClass(Money::class)]
final class ExchangeRateTest extends TestCase
{
    public function testConvert(): void
    {
        $rate = new ExchangeRate('USD', 'EUR', '0.91');
        $usd = Money::usd('100.00');
        $eur = $rate->convert($usd);

        self::assertSame('EUR', $eur->currencyCode());
        self::assertSame('91.00', (string) $eur->amount());
    }

    public function testConvertWithDecimalRate(): void
    {
        $rate = new ExchangeRate('EUR', 'GBP', '0.856');
        $eur = Money::eur('50.00');
        $gbp = $rate->convert($eur);

        self::assertSame('GBP', $gbp->currencyCode());
        self::assertSame('42.80', (string) $gbp->amount());
    }

    public function testConvertCurrencyMismatchThrows(): void
    {
        $rate = new ExchangeRate('USD', 'EUR', '0.91');
        $gbp = Money::gbp('100.00');

        $this->expectException(LogicException::class);
        $rate->convert($gbp);
    }

    public function testInverse(): void
    {
        $rate = new ExchangeRate('USD', 'EUR', '0.91');
        $inverse = $rate->inverse();

        self::assertSame('EUR', $inverse->from->getCurrencyCode());
        self::assertSame('USD', $inverse->to->getCurrencyCode());

        // 1 / 0.91 ≈ 1.0989010989
        self::assertEqualsWithDelta(
            1.0989,
            (float) (string) $inverse->rate,
            0.001,
        );
    }

    public function testRoundTrip(): void
    {
        $rate = new ExchangeRate('USD', 'EUR', '0.91');
        $usd = Money::usd('100.00');

        $eur = $rate->convert($usd);
        $usdBack = $rate->inverse()->convert($eur);

        // Due to rounding we may lose a cent
        self::assertEqualsWithDelta(
            100.0,
            (float) (string) $usdBack->amount(),
            0.02,
        );
    }
}
