<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\Information;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\BinarySystem;
use Monadial\Siphon\Unit\Information\InformationUnit;
use Override;

/**
 * IEC binary unit of information equal to 2^50 bytes.
 *
 * Symbol: PiB. Conversion factor: 2^50 = 1,125,899,906,842,624 (1 PiB = 1,125,899,906,842,624 B).
 * Used in large-scale computing and distributed storage systems.
 *
 * @see Pebibytes::make()
 */
final readonly class Pebibytes extends InformationUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BinarySystem::PEBI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'PiB';
    }
}
