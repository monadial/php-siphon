<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Angle;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\AngleUnit;
use Override;

/**
 * Gradian (gon) -- a unit of plane angle equal to pi/200 radians.
 *
 * Also known as a gon or grad. Divides a right angle into 100 equal parts,
 * making a full circle 400 gradians. Primarily used in surveying, mining,
 * and some European engineering contexts.
 *
 * @see Angle::gradians() to create an Angle quantity in gradians.
 */
final readonly class Gradians extends AngleUnit
{
    private const string FACTOR = '0.01570796326794896619';

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'gon';
    }
}
