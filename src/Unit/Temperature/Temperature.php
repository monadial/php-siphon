<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Temperature;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Temperature\Temperature\Celsius;
use Monadial\Siphon\Unit\Temperature\Temperature\Fahrenheit;
use Monadial\Siphon\Unit\Temperature\Temperature\Kelvins;
use Monadial\Siphon\Unit\Temperature\Temperature\Kilokelvins;
use Monadial\Siphon\Unit\Temperature\Temperature\Millikelvins;
use Monadial\Siphon\Unit\Temperature\Temperature\Rankine;

/**
 * Temperature quantity measuring thermal energy.
 *
 * Temperature is one of the seven SI base quantities with dimension formula Theta.
 * The SI base unit is the kelvin (K). Temperature conversions involve both scaling
 * factors and offsets for non-absolute scales.
 *
 * Available units: Millikelvins (10^-3), Kelvins (1), Kilokelvins (10^3),
 * Celsius (factor 1, offset 273.15), Fahrenheit (factor 5/9, offset 459.67),
 * Rankine (factor 5/9, no offset).
 *
 * ```php
 * $temp = Temperature::celsius(100); // boiling point of water
 * $kelvin = $temp->toKelvins(); // 373.15 K
 * $fahr = $temp->toFahrenheit(); // 212 degF
 * ```
 *
 * @template-extends Quantity<TemperatureUnit>
 */
final readonly class Temperature extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function celsius(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Celsius::make());
    }

    public static function fahrenheit(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Fahrenheit::make());
    }

    public static function kelvins(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kelvins::make());
    }

    public static function kelvin(BigDecimal|int|float|string $value): self
    {
        return self::kelvins($value);
    }

    public static function kilokelvins(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kilokelvins::make());
    }

    public static function kilokelvin(BigDecimal|int|float|string $value): self
    {
        return self::kilokelvins($value);
    }

    public static function millikelvins(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Millikelvins::make());
    }

    public static function millikelvin(BigDecimal|int|float|string $value): self
    {
        return self::millikelvins($value);
    }

    public static function rankine(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Rankine::make());
    }

    // END_TYPED_FACTORIES
    public function toMillikelvins(): self
    {
        return $this->scaleTo(Millikelvins::make());
    }

    public function toKelvins(): self
    {
        return $this->scaleTo(Kelvins::make());
    }

    public function toKilokelvins(): self
    {
        return $this->scaleTo(Kilokelvins::make());
    }

    public function toCelsius(): self
    {
        return $this->scaleTo(Celsius::make());
    }

    public function toFahrenheit(): self
    {
        return $this->scaleTo(Fahrenheit::make());
    }

    public function toRankine(): self
    {
        return $this->scaleTo(Rankine::make());
    }
}
