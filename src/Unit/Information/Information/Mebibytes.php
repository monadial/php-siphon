<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\Information;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\BinarySystem;
use Monadial\Siphon\Unit\Information\InformationUnit;
use Override;

/**
 * IEC binary unit of information equal to 1,048,576 bytes.
 *
 * Symbol: MiB. Conversion factor: 2^20 = 1,048,576 (1 MiB = 1,048,576 B).
 * Used for precise binary memory and cache size measurements.
 *
 * @see Mebibytes::make()
 */
final readonly class Mebibytes extends InformationUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BinarySystem::MEBI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'MiB';
    }
}
