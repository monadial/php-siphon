<?php

declare(strict_types=1);

namespace Monadial\Siphon\System;

use Brick\Math\BigDecimal;
use Override;

enum BinarySystem implements System
{
    case BYTE;
    case KIBI;
    case MEBI;
    case GIBI;
    case TEBI;
    case PEBI;
    case EXBI;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(match ($this) {
            self::BYTE => '1',
            self::KIBI => '1024',
            self::MEBI => '1048576',
            self::GIBI => '1073741824',
            self::TEBI => '1099511627776',
            self::PEBI => '1125899906842624',
            self::EXBI => '1152921504606846976',
        });
    }
}
