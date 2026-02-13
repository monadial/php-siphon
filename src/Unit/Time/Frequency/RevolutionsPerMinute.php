<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Time\Frequency;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Time\FrequencyUnit;
use Override;

final readonly class RevolutionsPerMinute extends FrequencyUnit
{
    private const string FACTOR = '0.01666666666666666667';

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'rpm';
    }
}
