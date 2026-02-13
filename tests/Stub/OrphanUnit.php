<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Stub;

use Brick\Math\BigDecimal;
use Monadial\Siphon\UnitOfMeasure;

/**
 * A unit not nested inside a Quantity namespace — used to test UnitOfMeasure::from() error path.
 */
final readonly class OrphanUnit extends UnitOfMeasure
{
    public function factor(): BigDecimal
    {
        return BigDecimal::one();
    }

    public function symbol(): string
    {
        return 'orphan';
    }
}
