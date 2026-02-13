<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Energy;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\EnergyUnit;
use Override;

/**
 * Electronvolt (eV) -- the energy gained by an electron crossing a 1-volt potential.
 *
 * Symbol: eV. Conversion factor: 1.602176634e-19 (1 eV = 1.602176634e-19 J exactly).
 * The standard energy unit in atomic, nuclear, and particle physics. Typical chemical
 * bond energies are a few eV, while particle accelerators operate in GeV to TeV ranges.
 *
 * @see Energy::electronvolts() for the factory method
 */
final readonly class Electronvolts extends EnergyUnit
{
    private const float FACTOR = 1.602176634e-19;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'eV';
    }
}
