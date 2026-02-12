<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Time\Frequency;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Time\FrequencyUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class RevolutionsPerMinute extends FrequencyUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('0.01666666666666666667');
    }
}
