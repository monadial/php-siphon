<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Light\LuminousIntensity;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Light\LuminousIntensityUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class Kilocandelas extends LuminousIntensityUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }
}
