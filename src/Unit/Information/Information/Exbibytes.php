<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\Information;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\BinarySystem;
use Monadial\Siphon\Unit\Information\InformationUnit;
use Override;

/**
 * IEC binary unit of information equal to 2^60 bytes.
 *
 * Symbol: EiB. Conversion factor: 2^60 = 1,152,921,504,606,846,976 (1 EiB = 2^60 B).
 * The largest IEC binary prefix supported, used for planetary-scale data measurements.
 *
 * @see Exbibytes::make()
 */
final readonly class Exbibytes extends InformationUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BinarySystem::EXBI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'EiB';
    }
}
