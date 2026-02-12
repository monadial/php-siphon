<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Dimensionless;

use Brick\Math\BigDecimal;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Dimensionless\Dimensionless\Dozen;
use Monadial\Siphon\Unit\Dimensionless\Dimensionless\Each;
use Monadial\Siphon\Unit\Dimensionless\Dimensionless\Gross;
use Monadial\Siphon\Unit\Dimensionless\Dimensionless\Percent;
use Monadial\Siphon\Unit\Dimensionless\Dimensionless\Score;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<DimensionlessUnit>
 */
final readonly class Dimensionless extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function dozen(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Dozen::make());
    }

    public static function each(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Each::make());
    }

    public static function gross(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Gross::make());
    }

    public static function gros(BigDecimal|int|float|string $value): self
    {
        return self::gross($value);
    }

    public static function percent(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Percent::make());
    }

    public static function score(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Score::make());
    }

    // END_TYPED_FACTORIES
    public function toEach(): self
    {
        // phpcs:ignore PHPCompatibility.FunctionUse.RemovedFunctions.eachDeprecated
        return $this->scaleTo(Each::make());
    }

    public function toDozen(): self
    {
        return $this->scaleTo(Dozen::make());
    }

    public function toScore(): self
    {
        return $this->scaleTo(Score::make());
    }

    public function toGross(): self
    {
        return $this->scaleTo(Gross::make());
    }

    public function toPercent(): self
    {
        return $this->scaleTo(Percent::make());
    }
}
