<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Time\Frequency;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Time\FrequencyUnit;
use Override;

final readonly class Terahertz extends FrequencyUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::TERA->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'THz';
    }
}
