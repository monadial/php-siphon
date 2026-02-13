<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Time\Time;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Time\TimeUnit;
use Override;

final readonly class Months extends TimeUnit
{
    private const int FACTOR = 2_629_746;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'mo';
    }
}
