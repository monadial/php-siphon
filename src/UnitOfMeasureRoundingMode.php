<?php

declare(strict_types=1);

namespace Monadial\Siphon;

enum UnitOfMeasureRoundingMode
{
    case ROUND_UP;
    case ROUND_DOWN;
    case ROUND_HALF_UP;
    case ROUND_HALF_DOWN;
    case ROUND_HALF_EVEN;
    case ROUND_HALF_ODD;
    case ROUND_CEILING;
    case ROUND_FLOOR;
    case ROUND_HALF_CEILING;
    case ROUND_HALF_FLOOR;
    case ROUND_UNNECESSARY;
}
