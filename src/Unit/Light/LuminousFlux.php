<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Light;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Light\LuminousFlux\Kilolumens;
use Monadial\Siphon\Unit\Light\LuminousFlux\Lumens;
use Monadial\Siphon\Unit\Light\LuminousFlux\Millilumens;

/**
 * Luminous flux quantity measuring the total amount of visible light emitted by a source.
 *
 * Dimension formula: cd * sr (luminous intensity times solid angle). The SI derived unit
 * is the lumen (lm). Available units: Millilumens (10^-3), Lumens (1), Kilolumens (10^3).
 *
 * ```php
 * $flux = LuminousFlux::lumens(800); // typical 60W-equivalent LED bulb
 * $kilo = $flux->toKilolumens(); // 0.8 klm
 * ```
 *
 * @template-extends Quantity<LuminousFluxUnit>
 */
final readonly class LuminousFlux extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function kilolumens(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kilolumens::make());
    }

    public static function kilolumen(BigDecimal|int|float|string $value): self
    {
        return self::kilolumens($value);
    }

    public static function lumens(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Lumens::make());
    }

    public static function lumen(BigDecimal|int|float|string $value): self
    {
        return self::lumens($value);
    }

    public static function millilumens(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Millilumens::make());
    }

    public static function millilumen(BigDecimal|int|float|string $value): self
    {
        return self::millilumens($value);
    }

    // END_TYPED_FACTORIES
    public function toMillilumens(): self
    {
        return $this->scaleTo(Millilumens::make());
    }

    public function toLumens(): self
    {
        return $this->scaleTo(Lumens::make());
    }

    public function toKilolumens(): self
    {
        return $this->scaleTo(Kilolumens::make());
    }
}
