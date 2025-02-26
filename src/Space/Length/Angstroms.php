<?php

declare(strict_types=1);

namespace Monadial\Siphon\Space\Length;

use Brick\Math\BigDecimal;
use Brick\Math\BigInteger;
use Fp\Collections\ArrayList;
use Monadial\Siphon\MetricSystem;
use Monadial\Siphon\Space\LengthUnit;
use Override;

final readonly class Angstroms extends LengthUnit
{
    #[Override]
    public function symbols(): ArrayList
    {
        return ArrayList::collect(['Å', 'a']);
    }

    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::PICO->factor()->multipliedBy(BigInteger::of(100));
    }
}
