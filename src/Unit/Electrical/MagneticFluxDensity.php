<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Brick\Math\BigDecimal;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Electrical\MagneticFluxDensity\Gauss;
use Monadial\Siphon\Unit\Electrical\MagneticFluxDensity\Microteslas;
use Monadial\Siphon\Unit\Electrical\MagneticFluxDensity\Milliteslas;
use Monadial\Siphon\Unit\Electrical\MagneticFluxDensity\Teslas;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<MagneticFluxDensityUnit>
 */
final readonly class MagneticFluxDensity extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function gauss(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Gauss::make());
    }

    public static function gaus(BigDecimal|int|float|string $value): self
    {
        return self::gauss($value);
    }

    public static function microteslas(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Microteslas::make());
    }

    public static function microtesla(BigDecimal|int|float|string $value): self
    {
        return self::microteslas($value);
    }

    public static function milliteslas(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Milliteslas::make());
    }

    public static function millitesla(BigDecimal|int|float|string $value): self
    {
        return self::milliteslas($value);
    }

    public static function teslas(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Teslas::make());
    }

    public static function tesla(BigDecimal|int|float|string $value): self
    {
        return self::teslas($value);
    }

    // END_TYPED_FACTORIES
    public function toMicroteslas(): self
    {
        return $this->scaleTo(Microteslas::make());
    }

    public function toMilliteslas(): self
    {
        return $this->scaleTo(Milliteslas::make());
    }

    public function toTeslas(): self
    {
        return $this->scaleTo(Teslas::make());
    }

    public function toGauss(): self
    {
        return $this->scaleTo(Gauss::make());
    }
}
