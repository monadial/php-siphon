<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\Information;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Information\InformationUnit;
use Override;

/**
 * SI decimal unit of information equal to 10^12 bytes.
 *
 * Symbol: TB. Conversion factor: 10^12 (1 TB = 1,000,000,000,000 B).
 * Used for large-scale storage such as hard drives and cloud storage quotas.
 *
 * @see Terabytes::make()
 */
final readonly class Terabytes extends InformationUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::TERA->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'TB';
    }
}
