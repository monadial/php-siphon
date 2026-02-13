<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Power;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\PowerUnit;
use Override;

/**
 * Horsepower (hp) -- a traditional unit of power.
 *
 * Symbol: hp. Conversion factor: 745.69987 (1 hp = 745.7 W approximately).
 * Originally defined by James Watt to compare steam engine output to draft horses.
 * Still widely used for rating engines, motors, and other mechanical equipment.
 *
 * @see Power::horsepower() for the factory method
 */
final readonly class Horsepower extends PowerUnit
{
    private const string FACTOR = '745.69987158227022';

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'hp';
    }
}
