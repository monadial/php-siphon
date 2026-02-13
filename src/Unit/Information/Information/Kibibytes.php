<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\Information;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\BinarySystem;
use Monadial\Siphon\Unit\Information\InformationUnit;
use Override;

/**
 * IEC binary unit of information equal to 1,024 bytes.
 *
 * Symbol: KiB. Conversion factor: 2^10 = 1,024 (1 KiB = 1,024 B).
 * Defined by IEC 80000-13 to unambiguously represent binary-based memory sizes.
 *
 * @see Kibibytes::make()
 */
final readonly class Kibibytes extends InformationUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BinarySystem::KIBI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'KiB';
    }
}
