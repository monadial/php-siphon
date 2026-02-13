<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Torque;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\TorqueUnit;
use Override;

/**
 * Pound-foot (lbf*ft) -- an imperial/US customary unit of torque.
 *
 * Symbol: lbf*ft. Conversion factor: 1.355818 (1 lbf*ft = 1.355818 N*m).
 * The standard unit for specifying engine torque and fastener tightening in the US.
 * A typical passenger car engine produces 200-400 lbf*ft of peak torque.
 *
 * @see Torque::poundFeet() for the factory method
 */
final readonly class PoundFeet extends TorqueUnit
{
    private const string FACTOR = '1.3558179483314004';

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'lbf*ft';
    }
}
