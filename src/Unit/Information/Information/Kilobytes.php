<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\Information;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Information\InformationUnit;
use Override;

/**
 * SI decimal unit of information equal to 1,000 bytes.
 *
 * Symbol: kB. Conversion factor: 10^3 (1 kB = 1,000 B).
 * Used in telecommunications and storage specifications following SI conventions.
 *
 * @see Kilobytes::make()
 */
final readonly class Kilobytes extends InformationUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'kB';
    }
}
