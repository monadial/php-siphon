<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\Information;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Information\InformationUnit;
use Override;

/**
 * SI decimal unit of information equal to 10^9 bytes.
 *
 * Symbol: GB. Conversion factor: 10^9 (1 GB = 1,000,000,000 B).
 * Commonly used for storage capacity of hard drives, SSDs, and RAM specifications.
 *
 * @see Gigabytes::make()
 */
final readonly class Gigabytes extends InformationUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::GIGA->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'GB';
    }
}
