<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricCharge;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Electrical\ElectricChargeUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class MilliampereHours extends ElectricChargeUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of('3.6');
    }
}
