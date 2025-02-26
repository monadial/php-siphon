<?php

declare(strict_types=1);

namespace Monadial\Siphon\Time;

use Monadial\Siphon\Quantity;

final readonly class Time extends Quantity
{
    private const NANOSECONDS_PER_SECOND = 1e9;
    private const MICROSECONDS_PER_SECOND = 1e6;
}
