<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Time;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Time\Frequency\Gigahertz;
use Monadial\Siphon\Unit\Time\Frequency\Hertz;
use Monadial\Siphon\Unit\Time\Frequency\Kilohertz;
use Monadial\Siphon\Unit\Time\Frequency\Megahertz;
use Monadial\Siphon\Unit\Time\Frequency\RevolutionsPerMinute;
use Monadial\Siphon\Unit\Time\Frequency\Terahertz;

/**
 * @template-extends Quantity<FrequencyUnit>
 */
final readonly class Frequency extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function gigahertz(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Gigahertz::make());
    }

    public static function hertz(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Hertz::make());
    }

    public static function kilohertz(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kilohertz::make());
    }

    public static function megahertz(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Megahertz::make());
    }

    public static function revolutionsPerMinute(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), RevolutionsPerMinute::make());
    }

    public static function terahertz(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Terahertz::make());
    }

    // END_TYPED_FACTORIES
    public function toHertz(): self
    {
        return $this->scaleTo(Hertz::make());
    }

    public function toKilohertz(): self
    {
        return $this->scaleTo(Kilohertz::make());
    }

    public function toMegahertz(): self
    {
        return $this->scaleTo(Megahertz::make());
    }

    public function toGigahertz(): self
    {
        return $this->scaleTo(Gigahertz::make());
    }

    public function toTerahertz(): self
    {
        return $this->scaleTo(Terahertz::make());
    }

    public function toRevolutionsPerMinute(): self
    {
        return $this->scaleTo(RevolutionsPerMinute::make());
    }
}
