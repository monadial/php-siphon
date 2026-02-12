<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Brick\Math\BigDecimal;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Mechanics\VolumeFlow\CubicMetersPerSecond;
use Monadial\Siphon\Unit\Mechanics\VolumeFlow\GallonsPerMinute;
use Monadial\Siphon\Unit\Mechanics\VolumeFlow\LitresPerMinute;
use Monadial\Siphon\Unit\Mechanics\VolumeFlow\LitresPerSecond;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<VolumeFlowUnit>
 */
final readonly class VolumeFlow extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function cubicMetersPerSecond(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), CubicMetersPerSecond::make());
    }

    public static function gallonsPerMinute(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), GallonsPerMinute::make());
    }

    public static function litresPerMinute(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), LitresPerMinute::make());
    }

    public static function litresPerSecond(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), LitresPerSecond::make());
    }

    // END_TYPED_FACTORIES
    public function toCubicMetersPerSecond(): self
    {
        return $this->scaleTo(CubicMetersPerSecond::make());
    }

    public function toLitresPerMinute(): self
    {
        return $this->scaleTo(LitresPerMinute::make());
    }

    public function toGallonsPerMinute(): self
    {
        return $this->scaleTo(GallonsPerMinute::make());
    }

    public function toLitresPerSecond(): self
    {
        return $this->scaleTo(LitresPerSecond::make());
    }
}
