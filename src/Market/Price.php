<?php

declare(strict_types=1);

namespace Monadial\Siphon\Market;

use Brick\Math\RoundingMode;
use Monadial\Siphon\Quantity;
use Stringable;

/**
 * Represents a price per unit of a physical quantity (e.g., $5/kg, €0.12/kWh).
 *
 * @psalm-api
 * @psalm-immutable
 * @template T of Quantity
 */
final readonly class Price implements Stringable
{
    /**
     * @param Money $money    The monetary amount.
     * @param T     $quantity The denominator quantity (e.g., 1 kg).
     */
    public function __construct(
        private Money $money,
        private Quantity $quantity,
    ) {
    }

    /**
     * Calculate total cost for a given quantity.
     *
     * Price(5 USD / 1 kg) × 10 kg = 50 USD
     *
     * @psalm-api
     */
    public function times(Quantity $quantity): Money
    {
        $denominatorBase = $this->quantity->to($this->quantity->uom());
        $numeratorBase = $quantity->to($this->quantity->uom());

        $ratio = $numeratorBase->dividedBy($denominatorBase, 20, RoundingMode::HALF_UP);

        return $this->money->times($ratio);
    }

    /**
     * @psalm-api
     */
    public function money(): Money
    {
        return $this->money;
    }

    /**
     * @psalm-api
     * @return T
     */
    public function quantity(): Quantity
    {
        return $this->quantity;
    }

    /**
     * Returns string like "5.00 USD/kg".
     */
    public function __toString(): string
    {
        return $this->money . '/' . $this->quantity->uom()->symbol();
    }
}
