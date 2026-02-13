<?php

declare(strict_types=1);

namespace Monadial\Siphon\Market;

use Brick\Math\BigDecimal;
use Brick\Math\BigNumber;
use Brick\Math\RoundingMode;
use Brick\Money\Currency;
use Monadial\Siphon\Exception\InvalidArgument;

/**
 * Immutable exchange rate between two currencies for monetary conversion.
 *
 * Represents a directional conversion rate from one currency to another.
 * The rate is stored as an arbitrary-precision {@see BigDecimal} and must
 * be strictly positive.
 *
 * Usage:
 *
 *     // Create a USD -> EUR rate
 *     $rate = new ExchangeRate('USD', 'EUR', '0.85');
 *
 *     // Convert money
 *     $eur = $rate->convert(Money::usd('100.00')); // 85.00 EUR
 *
 *     // Get the inverse rate (EUR -> USD)
 *     $inverse = $rate->inverse(); // ExchangeRate(EUR, USD, 1.176...)
 *
 * @see Money::convertTo()
 */
final readonly class ExchangeRate
{
    /**
     * The source currency of this exchange rate.
     */
    public Currency $from;

    /**
     * The target currency of this exchange rate.
     */
    public Currency $to;

    /**
     * The conversion multiplier (must be strictly positive).
     *
     * To convert from {@see $from} to {@see $to}, multiply the amount by this rate.
     */
    public BigDecimal $rate;

    /**
     * Create a new exchange rate between two currencies.
     *
     * The rate must be strictly positive — a zero or negative rate will
     * throw an {@see InvalidArgument} exception.
     *
     * Example:
     *
     *     $rate = new ExchangeRate('USD', 'EUR', '0.85');
     *     $rate = new ExchangeRate(Currency::of('GBP'), Currency::of('JPY'), 190);
     *
     * @param Currency|string $from The source currency code or Currency instance.
     * @param Currency|string $to The target currency code or Currency instance.
     * @param BigNumber|int|float|string $rate The conversion multiplier (must be > 0).
     * @throws InvalidArgument If the rate is zero or negative.
     */
    public function __construct(
        Currency|string $from,
        Currency|string $to,
        BigNumber|int|float|string $rate,
    ) {
        $this->from = is_string($from) ? Currency::of($from) : $from;
        $this->to = is_string($to) ? Currency::of($to) : $to;
        $this->rate = BigDecimal::of($rate);

        if ($this->rate->isNegativeOrZero()) {
            throw new InvalidArgument(sprintf(
                'Exchange rate must be positive, got %s',
                $this->rate,
            ));
        }
    }

    /**
     * Convert a Money amount using this exchange rate.
     *
     * The given Money must be in this rate's source currency ({@see $from});
     * otherwise, an {@see InvalidArgument} exception is thrown. The result
     * is rounded using HALF_UP to the target currency's default decimal places.
     *
     * Example:
     *
     *     $rate = new ExchangeRate('USD', 'EUR', '0.85');
     *     $eur = $rate->convert(Money::usd('100.00')); // 85.00 EUR
     *
     * @param Money $money The Money to convert (must match {@see $from} currency).
     * @return Money A new Money in the target currency ({@see $to}).
     * @throws InvalidArgument If the Money's currency does not match the source currency.
     */
    public function convert(Money $money): Money
    {
        if ($money->currency()->getCurrencyCode() !== $this->from->getCurrencyCode()) {
            throw new InvalidArgument(sprintf(
                'Cannot convert %s using a %s→%s exchange rate',
                $money->currencyCode(),
                $this->from->getCurrencyCode(),
                $this->to->getCurrencyCode(),
            ));
        }

        $converted = $money->inner()->convertedTo(
            $this->to,
            $this->rate,
            null,
            RoundingMode::HALF_UP,
        );

        return Money::of($converted->getAmount(), $this->to);
    }

    /**
     * Compute the inverse exchange rate (swap source and target currencies).
     *
     * The inverse rate is calculated as `1 / rate` with 20 decimal places
     * of precision and HALF_UP rounding.
     *
     * Example:
     *
     *     $usdToEur = new ExchangeRate('USD', 'EUR', '0.85');
     *     $eurToUsd = $usdToEur->inverse(); // ExchangeRate(EUR, USD, 1.17647...)
     *
     * @return self A new ExchangeRate with swapped currencies and the reciprocal rate.
     * @throws InvalidArgument If the resulting rate is invalid (should not happen for valid inputs).
     */
    public function inverse(): self
    {
        $inverseRate = BigDecimal::one()->dividedBy($this->rate, 20, RoundingMode::HALF_UP);

        return new self($this->to, $this->from, $inverseRate);
    }
}
