<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\Information;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Information\InformationUnit;
use Override;

/**
 * SI decimal unit of information equal to 10^18 bytes.
 *
 * Symbol: EB. Conversion factor: 10^18 (1 EB = 1,000,000,000,000,000,000 B).
 * Used to describe global data volumes, internet traffic, and hyperscale storage.
 *
 * @see Exabytes::make()
 */
final readonly class Exabytes extends InformationUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::EXA->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'EB';
    }
}
