<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Temperature\Temperature;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Temperature\TemperatureUnit;
use Override;

/**
 * One thousandth of a kelvin.
 *
 * Symbol: mK. Conversion factor: 10^-3 (1 mK = 0.001 K).
 * Used in cryogenics and precision temperature measurements near absolute zero.
 *
 * @see Millikelvins::make()
 */
final readonly class Millikelvins extends TemperatureUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MILLI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'mK';
    }
}
