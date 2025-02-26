<?php

declare(strict_types=1);

namespace Monadial\Siphon;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Fp\Functional\Either\Either;
use Override;
use Stringable;

/**
 * @psalm-consistent-constructor
 * @template T of UnitOfMeasure
 */
abstract readonly class Quantity implements Stringable
{
    public function __construct(
        protected private(set) BigDecimal $value,
        protected private(set) UnitOfMeasure $uom,
        private PrecisionScale $scale = PrecisionScale::GENERAL_HIGH,
    ) {
    }

    /**
     * @return Option<Quantity<T>>
     */
    abstract public static function fromString(Stringable|string $input): Either;

    /**
     * @return Quantity<T>
     */
    public function to(UnitOfMeasure $uom): self
    {
        return match (true) {
            $uom instanceof $this->uom => $this,
            default => $this->flatMap(
                fn (self $quantity) => new static(
                    $this->uom
                        ->factor()
                        ->dividedBy($uom->factor(), $this->scale->scale(), RoundingMode::HALF_UP)
                        ->multipliedBy($quantity->value),
                    $uom,
                ),
            ),
        };
    }

    /**
     * Quantity plus another quantity.
     * This method returns a new quantity that is the result of adding the given quantity to this quantity.
     */
    public function plus(self $that): static
    {
        return $this
            ->flatMap(static fn (self $quantity) => new static($quantity->to($that->uom)->value->plus($that->value), $that->uom));
    }

    /**
     * Quantity plus a string.
     * This method returns a new quantity that is the result of adding the given string to this quantity.
     */
    public function plusString(Stringable|string $input): static
    {
        return $this
            ->plus(static::fromString($input));
    }

    /**
     * Quantity minus another quantity.
     * This method returns a new quantity that is the result of subtracting the given quantity from this quantity.
     */
    public function minus(self $that): static
    {
        return $this
            ->flatMap(static fn (self $quantity) => new static($quantity->to($that->uom)->value->minus($that->value), $that->uom));
    }

    /**
     * Quantity minus a string.
     * This method returns a new quantity that is the result of subtracting the given string from this quantity.
     */
    public function minusString(Stringable|string $input): static
    {
        return $this
            ->minus(static::fromString($input));
    }

    /**
     * Ceil the quantity.
     * This method returns a new quantity that is the result of rounding this quantity to the next whole number.
     */
    public function ceil(): static
    {
        return $this
            ->map(static fn (BigDecimal $value) => $value->toScale(0, RoundingMode::CEILING));
    }

    /**
     * Floor the quantity.
     * This method returns a new quantity that is the result of rounding this quantity to the previous whole number.
     */
    public function floor(): static
    {
        return $this
            ->map(static fn (BigDecimal $value) => $value->toScale(0, RoundingMode::FLOOR));
    }

    /**
     * Rint the quantity.
     * This method returns a new quantity that is the result of rounding this quantity to the nearest whole number.
     */
    public function rint(): static
    {
        return $this
            ->map(static fn (BigDecimal $value) => $value->toScale(0, RoundingMode::HALF_EVEN));
    }

    public function equals(self $that): bool
    {
        return $that->uom->equals($this->uom) && $that->value->isEqualTo($this->value);
    }

    /**
     * @param callable(BigDecimal): BigDecimal $f
     */
    public function map(callable $f): static
    {
        return new static($f($this->value), $this->uom);
    }

    /**
     * @param callable(self): self $f
     */
    public function flatMap(callable $f): self
    {
        return $f($this);
    }

    #[Override]
    public function __toString(): string
    {
        // If the scale is 0, then we don't need to display the decimal point.
        // because the value is a whole number and the scale is 0.
        if ($this->scale === PrecisionScale::UNSCALED || $this->value->getScale() === 0) {
            return sprintf(
                '%s %s',
                $this->value->getUnscaledValue(),
                $this->uom->symbols()->head()->get(),
            );
        }

        return sprintf(
            '%s %s',
            $this->value->toScale($this->scale->scale(), RoundingMode::HALF_UP),
            $this->uom->symbols()->head()->get(),
        );
    }
}
