<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Temperature\Temperature;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Temperature\TemperatureUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Kilokelvins extends TemperatureUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }
}
