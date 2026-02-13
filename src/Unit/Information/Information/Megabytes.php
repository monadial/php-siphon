<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\Information;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Information\InformationUnit;
use Override;

/**
 * SI decimal unit of information equal to 1,000,000 bytes.
 *
 * Symbol: MB. Conversion factor: 10^6 (1 MB = 1,000,000 B).
 * Commonly used for file sizes, memory specifications, and data transfer measurements.
 *
 * @see Megabytes::make()
 */
final readonly class Megabytes extends InformationUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MEGA->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'MB';
    }
}
