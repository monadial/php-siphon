<?php

declare(strict_types=1);

namespace Monadial\Siphon\Market;

use Brick\Math\BigDecimal;
use Brick\Math\BigNumber;
use Brick\Math\RoundingMode;
use Brick\Money\Currency;
use Brick\Money\Money as BrickMoney;
use LogicException;
use Monadial\Siphon\Quantity;
use Stringable;

/**
 * @psalm-api
 * @psalm-immutable
 */
final readonly class Money implements Stringable
{
    private function __construct(
        private BrickMoney $inner,
    ) {
    }

    // ---------------------------------------------------------------
    // Construction
    // ---------------------------------------------------------------

    /**
     * @psalm-api
     */
    public static function of(BigNumber|int|float|string $amount, Currency|string $currency): self
    {
        if (is_string($currency)) {
            $currency = Currency::of($currency);
        }

        return new self(BrickMoney::of($amount, $currency, null, RoundingMode::HALF_UP));
    }

    /**
     * @psalm-api
     */
    public static function ofMinor(BigNumber|int|float|string $amount, Currency|string $currency): self
    {
        if (is_string($currency)) {
            $currency = Currency::of($currency);
        }

        return new self(BrickMoney::ofMinor($amount, $currency, null, RoundingMode::HALF_UP));
    }

    /**
     * @psalm-api
     */
    public static function zero(Currency|string $currency): self
    {
        if (is_string($currency)) {
            $currency = Currency::of($currency);
        }

        return new self(BrickMoney::zero($currency));
    }

    /**
     * Parse a string like "50.00 USD" or "EUR 10".
     *
     * @psalm-api
     */
    public static function parse(string $input): self
    {
        if (!preg_match('/^\s*([A-Z]{3})\s+([+\-]?(?:\d+(?:\.\d+)?|\.\d+))\s*$/', $input, $m)
            && !preg_match('/^\s*([+\-]?(?:\d+(?:\.\d+)?|\.\d+))\s+([A-Z]{3})\s*$/', $input, $m)) {
            throw new LogicException(sprintf('Unable to parse money from "%s"', $input));
        }

        if (ctype_alpha($m[1])) {
            return self::of($m[2], $m[1]);
        }

        return self::of($m[1], $m[2]);
    }

    // ---------------------------------------------------------------
    // Currency-specific factories
    // ---------------------------------------------------------------

    /**
     * @psalm-api
     */
    public static function usd(BigNumber|int|float|string $amount): self
    {
        return self::of($amount, 'USD');
    }

    /**
     * @psalm-api
     */
    public static function eur(BigNumber|int|float|string $amount): self
    {
        return self::of($amount, 'EUR');
    }

    /**
     * @psalm-api
     */
    public static function gbp(BigNumber|int|float|string $amount): self
    {
        return self::of($amount, 'GBP');
    }

    /**
     * @psalm-api
     */
    public static function jpy(BigNumber|int|float|string $amount): self
    {
        return self::of($amount, 'JPY');
    }

    /**
     * @psalm-api
     */
    public static function chf(BigNumber|int|float|string $amount): self
    {
        return self::of($amount, 'CHF');
    }

    /**
     * @psalm-api
     */
    public static function czk(BigNumber|int|float|string $amount): self
    {
        return self::of($amount, 'CZK');
    }

    // ---------------------------------------------------------------
    // Arithmetic
    // ---------------------------------------------------------------

    /**
     * @psalm-api
     */
    public function plus(self $that): self
    {
        return new self($this->inner->plus($that->inner));
    }

    /**
     * @psalm-api
     */
    public function minus(self $that): self
    {
        return new self($this->inner->minus($that->inner));
    }

    /**
     * @psalm-api
     */
    public function times(BigNumber|int|float|string $scalar): self
    {
        return new self($this->inner->multipliedBy($scalar, RoundingMode::HALF_UP));
    }

    /**
     * @psalm-api
     */
    public function dividedBy(BigNumber|int|float|string $scalar): self
    {
        return new self($this->inner->dividedBy($scalar, RoundingMode::HALF_UP));
    }

    /**
     * @psalm-api
     */
    public function negate(): self
    {
        return new self($this->inner->negated());
    }

    /**
     * @psalm-api
     */
    public function abs(): self
    {
        return new self($this->inner->abs());
    }

    // ---------------------------------------------------------------
    // Comparisons
    // ---------------------------------------------------------------

    /**
     * @psalm-api
     */
    public function isEqualTo(self $that): bool
    {
        return $this->inner->isEqualTo($that->inner);
    }

    /**
     * @psalm-api
     */
    public function isGreaterThan(self $that): bool
    {
        return $this->inner->isGreaterThan($that->inner);
    }

    /**
     * @psalm-api
     */
    public function isLessThan(self $that): bool
    {
        return $this->inner->isLessThan($that->inner);
    }

    /**
     * @psalm-api
     */
    public function isGreaterThanOrEqualTo(self $that): bool
    {
        return $this->inner->isGreaterThanOrEqualTo($that->inner);
    }

    /**
     * @psalm-api
     */
    public function isLessThanOrEqualTo(self $that): bool
    {
        return $this->inner->isLessThanOrEqualTo($that->inner);
    }

    /**
     * @psalm-api
     */
    public function isZero(): bool
    {
        return $this->inner->isZero();
    }

    /**
     * @psalm-api
     */
    public function isPositive(): bool
    {
        return $this->inner->isPositive();
    }

    /**
     * @psalm-api
     */
    public function isNegative(): bool
    {
        return $this->inner->isNegative();
    }

    // ---------------------------------------------------------------
    // Conversion
    // ---------------------------------------------------------------

    /**
     * @psalm-api
     */
    public function convertTo(Currency|string $currency, ExchangeRate $rate): self
    {
        return $rate->convert($this);
    }

    // ---------------------------------------------------------------
    // Allocation
    // ---------------------------------------------------------------

    /**
     * @psalm-api
     * @return list<self>
     */
    public function split(int $parts): array
    {
        return array_map(
            static fn (BrickMoney $m): self => new self($m),
            $this->inner->split($parts),
        );
    }

    /**
     * @psalm-api
     * @return list<self>
     */
    public function allocate(int ...$ratios): array
    {
        return array_map(
            static fn (BrickMoney $m): self => new self($m),
            $this->inner->allocate(...$ratios),
        );
    }

    // ---------------------------------------------------------------
    // Access
    // ---------------------------------------------------------------

    /**
     * @psalm-api
     */
    public function amount(): BigDecimal
    {
        return $this->inner->getAmount();
    }

    /**
     * @psalm-api
     */
    public function currency(): Currency
    {
        return $this->inner->getCurrency();
    }

    /**
     * @psalm-api
     */
    public function currencyCode(): string
    {
        return $this->inner->getCurrency()->getCurrencyCode();
    }

    /**
     * Returns the underlying brick/money instance.
     *
     * @psalm-api
     */
    public function inner(): BrickMoney
    {
        return $this->inner;
    }

    // ---------------------------------------------------------------
    // Price creation
    // ---------------------------------------------------------------

    /**
     * Create a Price from this money per unit of a physical quantity.
     *
     * @psalm-api
     * @template T of Quantity
     * @param T $quantity
     * @return Price<T>
     */
    public function per(Quantity $quantity): Price
    {
        return new Price($this, $quantity);
    }

    // ---------------------------------------------------------------
    // String representation
    // ---------------------------------------------------------------

    /**
     * Returns string like "50.00 USD".
     */
    public function __toString(): string
    {
        return $this->inner->getAmount() . ' ' . $this->inner->getCurrency()->getCurrencyCode();
    }
}
