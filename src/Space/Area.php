<?php

declare(strict_types=1);

namespace Monadial\Siphon\Space;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Space\Area\SquareMeters;
use Monadial\Siphon\Space\Volume\CubicMeters;
use Stringable;

final readonly class Area extends Quantity
{
    public static function fromString(Stringable|string $input): self
    {
        // TODO: Implement fromString() method.
    }

    public function toVolume(Length $that): Volume
    {
        return $this->flatMap(static fn (self $area): Volume => match (true) {
            default => CubicMeters::apply($area->toSquareMeters()->value->multipliedBy($that->toMeters()))
        });
    }

    public function toSquareMeters(): self
    {
        return $this->to(SquareMeters::make());
    }
}
