<?php

declare(strict_types=1);

namespace Monadial\Siphon\Market;

use Brick\Math\RoundingMode;
use Closure;
use Monadial\Siphon\Quantity;
use Override;
use Stringable;

/**
 * Represents a price per unit of a physical quantity (e.g., $5/kg, EUR 0.12/kWh).
 *
 * Price is a generic value object parameterized by a Quantity subclass, pairing
 * a {@see Money} amount (the numerator) with a physical quantity denominator.
 * All instances are immutable — every transformation returns a new Price.
 *
 * Price implements several functional programming abstractions:
 *
 * - **Functor** via {@see map()} and {@see mapQuantity()} — transform one component
 * - **Bifunctor** via {@see bimap()} — transform both components simultaneously
 * - **Applicative Functor** via {@see pure()} and {@see map2()} — lift and combine
 * - **Monad** via {@see flatMap()} — chain dependent computations
 * - **Catamorphism** via {@see fold()} — eliminate the Price into an arbitrary value
 *
 * Usage:
 *
 *     // Create a price
 *     $price = Money::usd('5.00')->per(Mass::kilograms(1)); // $5/kg
 *
 *     // Calculate total cost
 *     $cost = $price->times(Mass::kilograms(10)); // $50.00
 *
 *     // Apply a 20% discount via Functor
 *     $discounted = $price->map(fn(Money $m) => $m->times('0.8')); // $4/kg
 *
 *     // Chain pricing logic via Monad
 *     $adjusted = $price->flatMap(fn(Money $m, Mass $q) =>
 *         new Price($m->plus(Money::usd('1.00')), $q)
 *     );
 *
 * @template T of Quantity
 * @see Money
 * @see Quantity
 */
final readonly class Price implements Stringable
{
    /**
     * Create a new Price from a monetary amount and a physical quantity denominator.
     *
     * @param Money $money The monetary amount (numerator), e.g. 5.00 USD.
     * @param T $quantity The denominator quantity (e.g., 1 kg, 1 kWh).
     */
    public function __construct(
        private Money $money,
        private Quantity $quantity,
    ) {
    }

    // ---------------------------------------------------------------
    // Applicative
    // ---------------------------------------------------------------

    /**
     * Lift a money/quantity pair into the Price context (Applicative pure / return).
     *
     * This is the Applicative Functor's unit operation. It wraps raw values
     * into the Price context without any transformation.
     *
     * Satisfies the Applicative identity law:
     *
     *     Price::pure($m, $q)->flatMap($f) === $f($m, $q) // left identity
     *
     * @template U of Quantity
     * @param Money $money The monetary amount to wrap.
     * @param U $quantity The physical quantity denominator to wrap.
     * @return self<U> A new Price wrapping the given values.
     */
    public static function pure(Money $money, Quantity $quantity): self
    {
        return new self($money, $quantity);
    }

    /**
     * Combine two prices using a binary function over their Money components (Applicative lift2).
     *
     * Applies {@see $fn} to the monetary amounts of both prices, using the
     * first price's quantity as the result denominator. This is useful for
     * combining prices within the same quantity domain — e.g., summing
     * a base price and a surcharge.
     *
     * Example:
     *
     *     $base = Money::usd('3.00')->per(Mass::kilograms(1));
     *     $surcharge = Money::usd('0.50')->per(Mass::kilograms(1));
     *     $total = Price::map2($base, $surcharge, fn(Money $a, Money $b) => $a->plus($b));
     *     // => Price($3.50 / 1 kg)
     *
     * @template U of Quantity
     * @param self<U> $a The first price (its quantity becomes the result denominator).
     * @param self<U> $b The second price.
     * @param Closure(Money, Money): Money $fn A binary function combining both monetary amounts.
     * @return self<U> A new Price with the combined money and $a's quantity.
     */
    public static function map2(self $a, self $b, Closure $fn): self
    {
        return new self($fn($a->money, $b->money), $a->quantity);
    }

    // ---------------------------------------------------------------
    // Cost calculation
    // ---------------------------------------------------------------

    /**
     * Calculate the total cost for a given quantity of goods.
     *
     * Multiplies this price's monetary amount by the ratio of the given
     * quantity to this price's denominator quantity. Both quantities are
     * normalized to the same unit before computing the ratio.
     *
     * Example:
     *
     *     $price = Money::usd('5.00')->per(Mass::kilograms(1));
     *     $cost = $price->times(Mass::grams(500)); // => Money(2.50 USD)
     *
     * @param T $quantity The quantity to price (e.g., 10 kg, 500 g).
     * @return Money The total monetary cost.
     */
    public function times(Quantity $quantity): Money
    {
        $denominatorBase = $this->quantity->to($this->quantity->uom());
        $numeratorBase = $quantity->to($this->quantity->uom());

        $ratio = $numeratorBase->dividedBy($denominatorBase, 20, RoundingMode::HALF_UP);

        return $this->money->times($ratio);
    }

    // ---------------------------------------------------------------
    // Functor
    // ---------------------------------------------------------------

    /**
     * Transform the monetary component while keeping the quantity unchanged (Functor fmap).
     *
     * Applies the given function to this price's Money, producing a new Price
     * with the transformed money and the original quantity denominator.
     *
     * Satisfies the Functor laws:
     *
     *     $p->map(fn($m) => $m) === $p // identity
     *     $p->map($f)->map($g) === $p->map(fn($m) => $g($f($m))) // composition
     *
     * Example:
     *
     *     $discounted = $price->map(fn(Money $m) => $m->times('0.8')); // 20% off
     *
     * @param Closure(Money): Money $fn A function transforming the monetary amount.
     * @return self<T> A new Price with the transformed money.
     */
    public function map(Closure $fn): self
    {
        return new self($fn($this->money), $this->quantity);
    }

    /**
     * Transform the quantity component while keeping the money unchanged (second Functor).
     *
     * Applies the given function to this price's Quantity, producing a new
     * Price with the original money and the transformed quantity denominator.
     * Useful for unit conversions within a price.
     *
     * Satisfies the Functor identity law:
     *
     *     $p->mapQuantity(fn($q) => $q) === $p
     *
     * Example:
     *
     *     // Convert denominator from kilograms to grams
     *     $perGram = $price->mapQuantity(fn(Mass $q) => $q->scaleTo(Grams::make()));
     *
     * @param Closure(T): T $fn A function transforming the quantity denominator.
     * @return self<T> A new Price with the transformed quantity.
     */
    public function mapQuantity(Closure $fn): self
    {
        return new self($this->money, $fn($this->quantity));
    }

    // ---------------------------------------------------------------
    // Bifunctor
    // ---------------------------------------------------------------

    /**
     * Transform both the money and quantity components simultaneously (Bifunctor bimap).
     *
     * Applies separate functions to each component in a single operation.
     * This is equivalent to calling {@see map()} and {@see mapQuantity()}
     * in sequence, but expressed as a single atomic transformation.
     *
     * Satisfies the Bifunctor identity law:
     *
     *     $p->bimap(fn($m) => $m, fn($q) => $q) === $p
     *
     * Example:
     *
     *     // Apply discount and convert units in one step
     *     $result = $price->bimap(
     *         fn(Money $m) => $m->times('0.8'), // 20% discount
     *         fn(Mass $q) => $q->scaleTo(Grams::make()), // kg -> g
     *     );
     *
     * @param Closure(Money): Money $moneyFn A function transforming the monetary amount.
     * @param Closure(T): T $quantityFn A function transforming the quantity denominator.
     * @return self<T> A new Price with both components transformed.
     */
    public function bimap(Closure $moneyFn, Closure $quantityFn): self
    {
        return new self($moneyFn($this->money), $quantityFn($this->quantity));
    }

    // ---------------------------------------------------------------
    // Monad
    // ---------------------------------------------------------------

    /**
     * Chain a computation that depends on both components and produces a new Price (Monad bind / >>=).
     *
     * The given function receives the current Money and Quantity and must
     * return a new Price. This enables sequencing of dependent pricing
     * computations — e.g., applying a surcharge that depends on the
     * current price level.
     *
     * Satisfies the Monad laws:
     *
     *     Price::pure($m, $q)->flatMap($f) === $f($m, $q) // left identity
     *     $p->flatMap(fn($m, $q) => Price::pure($m, $q)) === $p // right identity
     *     $p->flatMap($f)->flatMap($g) === $p->flatMap(fn($m, $q) => $f($m, $q)->flatMap($g)) // associativity
     *
     * Example:
     *
     *     // Add a weight-dependent surcharge
     *     $adjusted = $price->flatMap(fn(Money $m, Mass $q) =>
     *         new Price($m->plus(Money::usd('0.50')), $q)
     *     );
     *
     * @param Closure(Money, T): self<T> $fn A function producing a new Price from the current components.
     * @return self<T> The Price returned by {@see $fn}.
     */
    public function flatMap(Closure $fn): self
    {
        return $fn($this->money, $this->quantity);
    }

    // ---------------------------------------------------------------
    // Catamorphism
    // ---------------------------------------------------------------

    /**
     * Eliminate the Price by applying a function to both components (catamorphism / destructor).
     *
     * Extracts both the Money and Quantity from the Price context and
     * passes them to the given function, returning its result. This is
     * the universal way to "unwrap" a Price into any other type.
     *
     * Example:
     *
     *     $label = $price->fold(fn(Money $m, Mass $q) =>
     *         sprintf('%s per %s', $m->amount(), $q->uom()->symbol())
     *     );
     *     // => "5.00 per kg"
     *
     * @template R
     * @param Closure(Money, T): R $fn A function that consumes both components.
     * @return R The value produced by {@see $fn}.
     */
    public function fold(Closure $fn): mixed
    {
        return $fn($this->money, $this->quantity);
    }

    // ---------------------------------------------------------------
    // Equality
    // ---------------------------------------------------------------

    /**
     * Check structural equality of two prices.
     *
     * Two prices are equal when both their monetary amounts are equal
     * (same currency and amount) and their quantity denominators are
     * equal (same physical magnitude after unit normalization).
     *
     * @param self<T> $that The price to compare against.
     * @return bool True if both components are equal, false otherwise.
     */
    public function isEqualTo(self $that): bool
    {
        return $this->money->isEqualTo($that->money)
            && $this->quantity->isEqualTo($that->quantity);
    }

    // ---------------------------------------------------------------
    // Access
    // ---------------------------------------------------------------

    /**
     * Get the monetary amount (numerator) of this price.
     *
     * @return Money The monetary component, e.g. Money(5.00 USD).
     */
    public function money(): Money
    {
        return $this->money;
    }

    /**
     * Get the quantity denominator of this price.
     *
     * @return T The physical quantity denominator, e.g. Mass(1 kg).
     */
    public function quantity(): Quantity
    {
        return $this->quantity;
    }

    /**
     * Return a human-readable string representation of the price.
     *
     * Format: "{amount} {currency}/{unit symbol}", e.g. "5.00 USD/kg".
     *
     * @return string The formatted price string.
     */
    #[Override]
    public function __toString(): string
    {
        return (string) $this->money . '/' . $this->quantity->uom()->symbol();
    }
}
