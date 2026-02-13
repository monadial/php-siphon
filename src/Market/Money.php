<?php

declare(strict_types=1);

namespace Monadial\Siphon\Market;

use Brick\Math\BigDecimal;
use Brick\Math\BigNumber;
use Brick\Math\RoundingMode;
use Brick\Money\Currency;
use Brick\Money\Money as BrickMoney;
use Monadial\Siphon\Exception\InvalidArgument;
use Monadial\Siphon\Exception\ParseFailure;
use Monadial\Siphon\Quantity;
use Override;
use Stringable;

/**
 * Immutable monetary value backed by {@see BrickMoney} for precise currency arithmetic.
 *
 * Money wraps the `brick/money` library to provide a simplified, domain-oriented
 * API for monetary calculations. All arithmetic uses arbitrary-precision decimals
 * with HALF_UP rounding to avoid floating-point errors.
 *
 * All instances are immutable (`readonly`) — every operation returns a new Money.
 *
 * Usage:
 *
 *     // Create money with currency-specific factories
 *     $price = Money::usd('9.99');
 *     $tax = Money::usd('0.80');
 *
 *     // Arithmetic
 *     $total = $price->plus($tax); // 10.79 USD
 *     $half = $total->dividedBy(2); // 5.40 USD
 *
 *     // Comparisons
 *     $price->isGreaterThan($tax); // true
 *
 *     // Currency conversion
 *     $rate = new ExchangeRate('USD', 'EUR', '0.85');
 *     $eur = $price->convertTo('EUR', $rate);
 *
 *     // Price per quantity
 *     $perKg = $price->per(Mass::kilograms(1)); // Price<Mass>
 *
 * @see ExchangeRate
 * @see Price
 */
final readonly class Money implements Stringable
{
    /**
     * @param BrickMoney $inner The underlying brick/money instance.
     */
    private function __construct(
        private BrickMoney $inner,
    ) {
    }

    // ---------------------------------------------------------------
    // Construction
    // ---------------------------------------------------------------

    /**
     * Create a Money instance from a major-unit amount and a currency.
     *
     * The amount is in major currency units (e.g., dollars, euros).
     * Rounding uses HALF_UP to the currency's default scale.
     *
     * Example:
     *
     *     $money = Money::of('9.99', 'USD');
     *     $money = Money::of(10, Currency::of('EUR'));
     *
     * @param BigNumber|int|float|string $amount The monetary amount in major units.
     * @param Currency|string $currency The ISO 4217 currency code or Currency instance.
     * @return self A new Money instance.
     */
    public static function of(BigNumber|int|float|string $amount, Currency|string $currency): self
    {
        $resolved = is_string($currency) ? Currency::of($currency) : $currency;

        return new self(BrickMoney::of($amount, $resolved, null, RoundingMode::HALF_UP));
    }

    /**
     * Create a Money instance from a minor-unit amount (e.g., cents) and a currency.
     *
     * Example:
     *
     *     $money = Money::ofMinor(999, 'USD'); // $9.99
     *     $money = Money::ofMinor(100, 'JPY'); // 100 JPY (JPY has 0 decimal places)
     *
     * @param BigNumber|int|float|string $amount The monetary amount in minor units (e.g., cents).
     * @param Currency|string $currency The ISO 4217 currency code or Currency instance.
     * @return self A new Money instance.
     */
    public static function ofMinor(BigNumber|int|float|string $amount, Currency|string $currency): self
    {
        $resolved = is_string($currency) ? Currency::of($currency) : $currency;

        return new self(BrickMoney::ofMinor($amount, $resolved, null, RoundingMode::HALF_UP));
    }

    /**
     * Create a zero-valued Money in the given currency.
     *
     * Example:
     *
     *     $zero = Money::zero('USD'); // 0.00 USD
     *
     * @param Currency|string $currency The ISO 4217 currency code or Currency instance.
     * @return self A Money instance representing zero in the given currency.
     */
    public static function zero(Currency|string $currency): self
    {
        $resolved = is_string($currency) ? Currency::of($currency) : $currency;

        return new self(BrickMoney::zero($resolved));
    }

    /**
     * Parse a Money from a human-readable string.
     *
     * Accepts formats: "50.00 USD", "EUR 10", "-3.50 GBP".
     * The currency code must be a 3-letter uppercase ISO 4217 code.
     *
     * Example:
     *
     *     $money = Money::parse('50.00 USD'); // 50.00 USD
     *     $money = Money::parse('EUR 10'); // 10.00 EUR
     *
     * @param string $input The string to parse.
     * @return self The parsed Money instance.
     * @throws ParseFailure If the input does not match the expected format.
     */
    public static function parse(string $input): self
    {
        if (
            !preg_match('/^\s*([A-Z]{3})\s+([+\-]?(?:\d+(?:\.\d+)?|\.\d+))\s*$/', $input, $m)
            && !preg_match('/^\s*([+\-]?(?:\d+(?:\.\d+)?|\.\d+))\s+([A-Z]{3})\s*$/', $input, $m)
        ) {
            throw new ParseFailure(sprintf('Unable to parse money from "%s"', $input));
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
     * Create a Money in US Dollars (USD).
     *
     * @param BigNumber|int|float|string $amount The amount in dollars.
     * @return self A new Money in USD.
     */
    public static function usd(BigNumber|int|float|string $amount): self
    {
        return self::of($amount, 'USD');
    }

    /**
     * Create a Money in Euros (EUR).
     *
     * @param BigNumber|int|float|string $amount The amount in euros.
     * @return self A new Money in EUR.
     */
    public static function eur(BigNumber|int|float|string $amount): self
    {
        return self::of($amount, 'EUR');
    }

    /**
     * Create a Money in British Pounds (GBP).
     *
     * @param BigNumber|int|float|string $amount The amount in pounds.
     * @return self A new Money in GBP.
     */
    public static function gbp(BigNumber|int|float|string $amount): self
    {
        return self::of($amount, 'GBP');
    }

    /**
     * Create a Money in Japanese Yen (JPY).
     *
     * @param BigNumber|int|float|string $amount The amount in yen.
     * @return self A new Money in JPY.
     */
    public static function jpy(BigNumber|int|float|string $amount): self
    {
        return self::of($amount, 'JPY');
    }

    /**
     * Create a Money in Swiss Francs (CHF).
     *
     * @param BigNumber|int|float|string $amount The amount in francs.
     * @return self A new Money in CHF.
     */
    public static function chf(BigNumber|int|float|string $amount): self
    {
        return self::of($amount, 'CHF');
    }

    /**
     * Create a Money in Czech Koruna (CZK).
     *
     * @param BigNumber|int|float|string $amount The amount in koruna.
     * @return self A new Money in CZK.
     */
    public static function czk(BigNumber|int|float|string $amount): self
    {
        return self::of($amount, 'CZK');
    }

    // ---------------------------------------------------------------
    // Arithmetic
    // ---------------------------------------------------------------

    /**
     * Add another Money of the same currency.
     *
     * Both operands must share the same currency; otherwise, the underlying
     * brick/money library will throw an exception.
     *
     * @param self $that The amount to add.
     * @return self A new Money with the summed amount.
     */
    public function plus(self $that): self
    {
        return new self($this->inner->plus($that->inner));
    }

    /**
     * Subtract another Money of the same currency.
     *
     * Both operands must share the same currency; otherwise, the underlying
     * brick/money library will throw an exception.
     *
     * @param self $that The amount to subtract.
     * @return self A new Money with the difference.
     */
    public function minus(self $that): self
    {
        return new self($this->inner->minus($that->inner));
    }

    /**
     * Multiply the monetary amount by a dimensionless scalar.
     *
     * Uses HALF_UP rounding to the currency's default decimal places.
     *
     * Example:
     *
     *     Money::usd('10.00')->times(3); // 30.00 USD
     *     Money::usd('10.00')->times('0.8'); // 8.00 USD (20% discount)
     *
     * @param BigNumber|int|float|string $scalar The multiplier.
     * @return self A new Money with the scaled amount.
     */
    public function times(BigNumber|int|float|string $scalar): self
    {
        return new self($this->inner->multipliedBy($scalar, RoundingMode::HALF_UP));
    }

    /**
     * Divide the monetary amount by a dimensionless scalar.
     *
     * Uses HALF_UP rounding to the currency's default decimal places.
     *
     * Example:
     *
     *     Money::usd('10.00')->dividedBy(3); // 3.33 USD
     *
     * @param BigNumber|int|float|string $scalar The divisor.
     * @return self A new Money with the divided amount.
     */
    public function dividedBy(BigNumber|int|float|string $scalar): self
    {
        return new self($this->inner->dividedBy($scalar, RoundingMode::HALF_UP));
    }

    /**
     * Negate the monetary amount (multiply by -1).
     *
     * Example:
     *
     *     Money::usd('5.00')->negate(); // -5.00 USD
     *
     * @return self A new Money with the negated amount.
     */
    public function negate(): self
    {
        return new self($this->inner->negated());
    }

    /**
     * Return the absolute value of the monetary amount.
     *
     * Example:
     *
     *     Money::usd('-5.00')->abs(); // 5.00 USD
     *
     * @return self A new Money with the absolute amount.
     */
    public function abs(): self
    {
        return new self($this->inner->abs());
    }

    // ---------------------------------------------------------------
    // Comparisons
    // ---------------------------------------------------------------

    /**
     * Check whether two Money instances represent the same amount and currency.
     *
     * @param self $that The Money to compare against.
     * @return bool True if the amounts and currencies are equal.
     */
    public function isEqualTo(self $that): bool
    {
        return $this->inner->isEqualTo($that->inner);
    }

    /**
     * Check whether this Money is strictly greater than another.
     *
     * @param self $that The Money to compare against.
     * @return bool True if this amount is greater.
     */
    public function isGreaterThan(self $that): bool
    {
        return $this->inner->isGreaterThan($that->inner);
    }

    /**
     * Check whether this Money is strictly less than another.
     *
     * @param self $that The Money to compare against.
     * @return bool True if this amount is less.
     */
    public function isLessThan(self $that): bool
    {
        return $this->inner->isLessThan($that->inner);
    }

    /**
     * Check whether this Money is greater than or equal to another.
     *
     * @param self $that The Money to compare against.
     * @return bool True if this amount is greater than or equal.
     */
    public function isGreaterThanOrEqualTo(self $that): bool
    {
        return $this->inner->isGreaterThanOrEqualTo($that->inner);
    }

    /**
     * Check whether this Money is less than or equal to another.
     *
     * @param self $that The Money to compare against.
     * @return bool True if this amount is less than or equal.
     */
    public function isLessThanOrEqualTo(self $that): bool
    {
        return $this->inner->isLessThanOrEqualTo($that->inner);
    }

    /**
     * Check whether this Money represents exactly zero.
     *
     * @return bool True if the amount is zero.
     */
    public function isZero(): bool
    {
        return $this->inner->isZero();
    }

    /**
     * Check whether this Money represents a positive (greater than zero) amount.
     *
     * @return bool True if the amount is positive.
     */
    public function isPositive(): bool
    {
        return $this->inner->isPositive();
    }

    /**
     * Check whether this Money represents a negative (less than zero) amount.
     *
     * @return bool True if the amount is negative.
     */
    public function isNegative(): bool
    {
        return $this->inner->isNegative();
    }

    // ---------------------------------------------------------------
    // Conversion
    // ---------------------------------------------------------------

    /**
     * Convert this Money to a different currency using an exchange rate.
     *
     * The target currency must match the exchange rate's target currency;
     * otherwise, an {@see InvalidArgument} exception is thrown.
     *
     * Example:
     *
     *     $rate = new ExchangeRate('USD', 'EUR', '0.85');
     *     $eur = Money::usd('100.00')->convertTo('EUR', $rate); // 85.00 EUR
     *
     * @param Currency|string $currency The target currency code or Currency instance.
     * @param ExchangeRate $rate The exchange rate to apply.
     * @return self A new Money in the target currency.
     * @throws InvalidArgument If the target currency does not match the exchange rate.
     */
    public function convertTo(Currency|string $currency, ExchangeRate $rate): self
    {
        $targetCode = is_string($currency) ? $currency : $currency->getCurrencyCode();
        if ($targetCode !== $rate->to->getCurrencyCode()) {
            throw new InvalidArgument(sprintf(
                'Currency %s does not match exchange rate target %s',
                $targetCode,
                $rate->to->getCurrencyCode(),
            ));
        }

        return $rate->convert($this);
    }

    // ---------------------------------------------------------------
    // Allocation
    // ---------------------------------------------------------------

    /**
     * Split this Money into N equal parts, distributing any remainder across the first parts.
     *
     * Uses the underlying brick/money split algorithm which guarantees that
     * the sum of all parts equals the original amount (no rounding loss).
     *
     * Example:
     *
     *     Money::usd('10.00')->split(3); // [3.34 USD, 3.33 USD, 3.33 USD]
     *
     * @param int $parts The number of equal parts to split into.
     * @return list<self> An array of Money instances summing to this amount.
     */
    public function split(int $parts): array
    {
        return array_values(array_map(
            static fn (BrickMoney $m): self => new self($m),
            $this->inner->split($parts),
        ));
    }

    /**
     * Allocate this Money proportionally according to the given ratios.
     *
     * Uses the underlying brick/money allocation algorithm which guarantees
     * that the sum of all parts equals the original amount (no rounding loss).
     *
     * Example:
     *
     *     // Split $10 in a 70/30 ratio
     *     Money::usd('10.00')->allocate(70, 30); // [7.00 USD, 3.00 USD]
     *
     * @param int ...$ratios The allocation ratios (positive integers).
     * @return list<self> An array of Money instances summing to this amount.
     */
    public function allocate(int ...$ratios): array
    {
        return array_values(array_map(
            static fn (BrickMoney $m): self => new self($m),
            $this->inner->allocate(...$ratios),
        ));
    }

    // ---------------------------------------------------------------
    // Access
    // ---------------------------------------------------------------

    /**
     * Get the numeric amount as a BigDecimal.
     *
     * Returns the amount in major currency units (e.g., "9.99" for $9.99).
     *
     * @return BigDecimal The monetary amount.
     */
    public function amount(): BigDecimal
    {
        return $this->inner->getAmount();
    }

    /**
     * Get the currency of this Money.
     *
     * @return Currency The ISO 4217 currency.
     */
    public function currency(): Currency
    {
        return $this->inner->getCurrency();
    }

    /**
     * Get the ISO 4217 currency code as a string (e.g., "USD", "EUR").
     *
     * @return string The 3-letter currency code.
     */
    public function currencyCode(): string
    {
        return $this->inner->getCurrency()->getCurrencyCode();
    }

    /**
     * Get the underlying brick/money instance for interoperability.
     *
     * Use this when you need access to brick/money features not exposed
     * by this wrapper (e.g., custom rounding modes, minor amounts).
     *
     * @return BrickMoney The underlying brick/money Money instance.
     */
    public function inner(): BrickMoney
    {
        return $this->inner;
    }

    // ---------------------------------------------------------------
    // Price creation
    // ---------------------------------------------------------------

    /**
     * Create a {@see Price} from this Money per unit of a physical quantity.
     *
     * This is the primary way to construct Price instances, providing a
     * natural DSL: `Money::usd('5.00')->per(Mass::kilograms(1))`.
     *
     * Example:
     *
     *     $perKg = Money::usd('5.00')->per(Mass::kilograms(1));
     *     $perKwh = Money::eur('0.12')->per(Energy::kilowattHours(1));
     *
     * @template T of Quantity
     * @param T $quantity The denominator quantity (e.g., 1 kg, 1 kWh).
     * @return Price<T> A new Price pairing this Money with the quantity.
     */
    public function per(Quantity $quantity): Price
    {
        return new Price($this, $quantity);
    }

    // ---------------------------------------------------------------
    // String representation
    // ---------------------------------------------------------------

    /**
     * Return a human-readable string representation of the money.
     *
     * Format: "{amount} {currency}", e.g. "50.00 USD", "0.12 EUR".
     *
     * @return string The formatted money string.
     */
    #[Override]
    public function __toString(): string
    {
        return (string) $this->inner->getAmount() . ' ' . $this->inner->getCurrency()->getCurrencyCode();
    }
}
