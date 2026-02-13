<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\Information;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Information\InformationUnit;
use Override;

/**
 * SI decimal unit of information equal to 10^15 bytes.
 *
 * Symbol: PB. Conversion factor: 10^15 (1 PB = 1,000,000,000,000,000 B).
 * Used in enterprise storage, data centers, and large-scale data analytics.
 *
 * @see Petabytes::make()
 */
final readonly class Petabytes extends InformationUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::PETA->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'PB';
    }
}
