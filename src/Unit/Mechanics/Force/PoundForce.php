<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Force;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\ForceUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class PoundForce extends ForceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('4.4482216152605');
    }
}
