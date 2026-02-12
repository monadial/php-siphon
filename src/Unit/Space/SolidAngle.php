<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space;

use Brick\Math\BigDecimal;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Space\SolidAngle\SquareDegrees;
use Monadial\Siphon\Unit\Space\SolidAngle\Steradians;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<SolidAngleUnit>
 */
final readonly class SolidAngle extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function squareDegrees(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), SquareDegrees::make());
    }

    public static function squareDegree(BigDecimal|int|float|string $value): self
    {
        return self::squareDegrees($value);
    }

    public static function steradians(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Steradians::make());
    }

    public static function steradian(BigDecimal|int|float|string $value): self
    {
        return self::steradians($value);
    }

    // END_TYPED_FACTORIES
    public function toSteradians(): self
    {
        return $this->scaleTo(Steradians::make());
    }

    public function toSquareDegrees(): self
    {
        return $this->scaleTo(SquareDegrees::make());
    }
}
