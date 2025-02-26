<?php

declare(strict_types=1);

namespace Monadial\Siphon\Space;

use Brick\Math\BigDecimal;
use Monadial\Siphon\UnitOfMeasure;
use Monadial\Siphon\UnitOfMeasureRoundingMode;
use Override;

abstract readonly class AreaUnit extends UnitOfMeasure
{
    #[Override]
    public static function apply(BigDecimal $value): Area
    {
        return new Area($value, new static());
    }

    public function scale(): int
    {
        // TODO: Implement scale() method.
    }

    public function roundingMode(): UnitOfMeasureRoundingMode
    {
        // TODO: Implement roundingMode() method.
    }
}
