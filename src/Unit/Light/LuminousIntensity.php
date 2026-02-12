<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Light;

use Brick\Math\BigDecimal;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Light\LuminousIntensity\Candelas;
use Monadial\Siphon\Unit\Light\LuminousIntensity\Kilocandelas;
use Monadial\Siphon\Unit\Light\LuminousIntensity\Millicandelas;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<LuminousIntensityUnit>
 */
final readonly class LuminousIntensity extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function candelas(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Candelas::make());
    }

    public static function candela(BigDecimal|int|float|string $value): self
    {
        return self::candelas($value);
    }

    public static function kilocandelas(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kilocandelas::make());
    }

    public static function kilocandela(BigDecimal|int|float|string $value): self
    {
        return self::kilocandelas($value);
    }

    public static function millicandelas(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Millicandelas::make());
    }

    public static function millicandela(BigDecimal|int|float|string $value): self
    {
        return self::millicandelas($value);
    }

    // END_TYPED_FACTORIES
    public function toMillicandelas(): self
    {
        return $this->scaleTo(Millicandelas::make());
    }

    public function toCandelas(): self
    {
        return $this->scaleTo(Candelas::make());
    }

    public function toKilocandelas(): self
    {
        return $this->scaleTo(Kilocandelas::make());
    }
}
