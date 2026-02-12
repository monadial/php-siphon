<?php

declare(strict_types=1);

namespace Monadial\Siphon\Market;

use Brick\Math\BigDecimal;
use Brick\Math\BigNumber;
use Brick\Math\RoundingMode;
use Brick\Money\Currency;
use LogicException;

/**
 * @psalm-api
 * @psalm-immutable
 */
final readonly class ExchangeRate
{
    public Currency $from;
    public Currency $to;
    public BigDecimal $rate;

    public function __construct(
        Currency|string $from,
        Currency|string $to,
        BigNumber|int|float|string $rate,
    ) {
        $this->from = is_string($from) ? Currency::of($from) : $from;
        $this->to = is_string($to) ? Currency::of($to) : $to;
        $this->rate = BigDecimal::of($rate);
    }

    /**
     * @psalm-api
     */
    public function convert(Money $money): Money
    {
        if ($money->currency()->getCurrencyCode() !== $this->from->getCurrencyCode()) {
            throw new LogicException(sprintf(
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
     * @psalm-api
     */
    public function inverse(): self
    {
        $inverseRate = BigDecimal::one()->dividedBy($this->rate, 10, RoundingMode::HALF_UP);

        return new self($this->to, $this->from, $inverseRate);
    }
}
