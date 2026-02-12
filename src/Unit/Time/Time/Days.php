<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Time\Time;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Time\TimeUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Days extends TimeUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(86400);
    }
}
