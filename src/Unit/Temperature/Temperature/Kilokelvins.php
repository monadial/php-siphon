<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Temperature\Temperature;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Temperature\TemperatureUnit;
use Override;

/**
 * One thousand kelvins.
 *
 * Symbol: kK. Conversion factor: 10^3 (1 kK = 1,000 K).
 * Used in astrophysics and plasma physics for stellar surface temperatures.
 *
 * @see Kilokelvins::make()
 */
final readonly class Kilokelvins extends TemperatureUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'kK';
    }
}
