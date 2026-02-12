<?php

declare(strict_types=1);

namespace Monadial\Siphon\System;

use Brick\Math\BigNumber;

interface System
{
    public function factor(): BigNumber;
}
