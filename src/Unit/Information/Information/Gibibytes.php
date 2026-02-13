<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\Information;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\BinarySystem;
use Monadial\Siphon\Unit\Information\InformationUnit;
use Override;

/**
 * IEC binary unit of information equal to 2^30 bytes (1,073,741,824 bytes).
 *
 * Symbol: GiB. Conversion factor: 2^30 = 1,073,741,824 (1 GiB = 1,073,741,824 B).
 * Used by operating systems to report actual RAM capacity and file system sizes.
 *
 * @see Gibibytes::make()
 */
final readonly class Gibibytes extends InformationUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BinarySystem::GIBI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'GiB';
    }
}
