<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Dimensionless\Dimensionless;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Dimensionless\DimensionlessUnit;
use Override;

/**
 * A counting unit representing twenty items.
 *
 * Symbol: score. Conversion factor: 20 (1 score = 20 each).
 * A traditional English counting unit, as in "four score and seven years ago."
 *
 * @see Score::make()
 */
final readonly class Score extends DimensionlessUnit
{
    private const int FACTOR = 20;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'score';
    }
}
