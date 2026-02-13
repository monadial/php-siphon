<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\Information;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\BinarySystem;
use Monadial\Siphon\Unit\Information\InformationUnit;
use Override;

/**
 * IEC binary unit of information equal to 2^40 bytes (1,099,511,627,776 bytes).
 *
 * Symbol: TiB. Conversion factor: 2^40 = 1,099,511,627,776 (1 TiB = 1,099,511,627,776 B).
 * Used for large binary storage measurements such as disk arrays and virtual volumes.
 *
 * @see Tebibytes::make()
 */
final readonly class Tebibytes extends InformationUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BinarySystem::TEBI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'TiB';
    }
}
