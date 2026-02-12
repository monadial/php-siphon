<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Length;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\LengthUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Inches extends LengthUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('0.0254');
    }
}
