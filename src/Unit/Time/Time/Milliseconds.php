<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Time\Time;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Time\TimeUnit;
use Override;

final readonly class Milliseconds extends TimeUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MILLI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'ms';
    }
}
