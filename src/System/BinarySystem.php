<?php

declare(strict_types=1);

namespace Monadial\Siphon\System;

use Brick\Math\BigDecimal;
use Override;

/**
 * IEC binary prefixes from BYTE (2^0) to EXBI (2^60).
 *
 * Each case represents a standard IEC binary prefix and returns its
 * {@see BigDecimal} multiplication factor via {@see factor()}. Binary
 * prefixes use powers of 1024 instead of 1000, distinguishing kibibytes
 * (KiB = 1024 B) from kilobytes (kB = 1000 B).
 *
 * Usage:
 *
 *     BinarySystem::KIBI->factor(); // BigDecimal("1024")
 *     BinarySystem::GIBI->factor(); // BigDecimal("1073741824")
 *
 * @see System
 * @see MetricSystem for SI decimal prefixes.
 */
enum BinarySystem implements System
{
    case BYTE;
    case KIBI;
    case MEBI;
    case GIBI;
    case TEBI;
    case PEBI;
    case EXBI;

    private const int BYTE_MULTIPLIER = 1;
    private const int KIBI_MULTIPLIER = 1024;
    private const int MEBI_MULTIPLIER = 1_048_576;
    private const int GIBI_MULTIPLIER = 1_073_741_824;
    private const int TEBI_MULTIPLIER = 1_099_511_627_776;
    private const int PEBI_MULTIPLIER = 1_125_899_906_842_624;
    private const int EXBI_MULTIPLIER = 1_152_921_504_606_846_976;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(match ($this) {
            self::BYTE => self::BYTE_MULTIPLIER,
            self::KIBI => self::KIBI_MULTIPLIER,
            self::MEBI => self::MEBI_MULTIPLIER,
            self::GIBI => self::GIBI_MULTIPLIER,
            self::TEBI => self::TEBI_MULTIPLIER,
            self::PEBI => self::PEBI_MULTIPLIER,
            self::EXBI => self::EXBI_MULTIPLIER,
        });
    }
}
