<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Time\Time;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Time\TimeUnit;
use Override;

final readonly class Hours extends TimeUnit
{
    private const int FACTOR = 3600;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'h';
    }
}
