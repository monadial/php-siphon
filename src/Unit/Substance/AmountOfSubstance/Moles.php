<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Substance\AmountOfSubstance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Substance\AmountOfSubstanceUnit;
use Override;

/**
 * The SI base unit of amount of substance.
 *
 * Symbol: mol. Conversion factor: 1 (base unit).
 * One mole contains exactly 6.02214076 x 10^23 elementary entities (atoms,
 * molecules, ions, etc.), as defined by the 2019 redefinition of SI base units.
 *
 * @see Moles::make()
 */
final readonly class Moles extends AmountOfSubstanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'mol';
    }
}
