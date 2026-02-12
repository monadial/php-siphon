<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Power;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\PowerUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class BtusPerHour extends PowerUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('0.29307107017222222222');
    }
}
