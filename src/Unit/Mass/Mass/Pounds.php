<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mass\Mass;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mass\MassUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Pounds extends MassUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('0.45359237');
    }
}
