<?php

declare(strict_types=1);

namespace Monadial\Siphon;

final readonly class DimensionPair
{
    public function __construct(
        public string $symbol,
        public UnitOfMeasure $oum,
    ) {
    }
}
