<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricCurrent;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricCurrentUnit;
use Override;

/**
 * The ampere (A) — SI base unit of electric current.
 *
 * One ampere represents one coulomb of charge passing a point per second.
 * Factor: 1 (base unit). The ampere is one of the seven SI base units.
 *
 * @see ElectricCurrent::amperes()
 */
final readonly class Amperes extends ElectricCurrentUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'A';
    }
}
