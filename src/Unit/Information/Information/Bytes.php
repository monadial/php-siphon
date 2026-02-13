<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\Information;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Information\InformationUnit;
use Override;

/**
 * The base unit of digital information, composed of eight bits.
 *
 * Symbol: B. Conversion factor: 1 (base unit).
 * The byte is the fundamental addressable unit of computer memory and storage.
 *
 * @see Bytes::make()
 */
final readonly class Bytes extends InformationUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'B';
    }
}
