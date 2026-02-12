<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mass;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Mechanics\Density;
use Monadial\Siphon\Unit\Mechanics\Force;
use Monadial\Siphon\Unit\Mechanics\MassFlow;
use Monadial\Siphon\Unit\Mechanics\Momentum;
use Monadial\Siphon\Unit\Motion\Acceleration;
use Monadial\Siphon\Unit\Motion\Velocity;
use Monadial\Siphon\Unit\Space\Volume;
use Monadial\Siphon\Unit\Time\Time;
use Monadial\Siphon\Unit\Mass\Mass\Grams;
use Monadial\Siphon\Unit\Mass\Mass\Kilograms;
use Monadial\Siphon\Unit\Mass\Mass\Micrograms;
use Monadial\Siphon\Unit\Mass\Mass\Milligrams;
use Monadial\Siphon\Unit\Mass\Mass\Ounces;
use Monadial\Siphon\Unit\Mass\Mass\Pounds;
use Monadial\Siphon\Unit\Mass\Mass\Stones;
use Monadial\Siphon\Unit\Mass\Mass\Tonnes;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<MassUnit>
 */
final readonly class Mass extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function grams(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Grams::make());
    }

    public static function gram(BigDecimal|int|float|string $value): self
    {
        return self::grams($value);
    }

    public static function kilograms(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kilograms::make());
    }

    public static function kilogram(BigDecimal|int|float|string $value): self
    {
        return self::kilograms($value);
    }

    public static function micrograms(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Micrograms::make());
    }

    public static function microgram(BigDecimal|int|float|string $value): self
    {
        return self::micrograms($value);
    }

    public static function milligrams(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Milligrams::make());
    }

    public static function milligram(BigDecimal|int|float|string $value): self
    {
        return self::milligrams($value);
    }

    public static function ounces(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Ounces::make());
    }

    public static function ounce(BigDecimal|int|float|string $value): self
    {
        return self::ounces($value);
    }

    public static function pounds(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Pounds::make());
    }

    public static function pound(BigDecimal|int|float|string $value): self
    {
        return self::pounds($value);
    }

    public static function stones(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Stones::make());
    }

    public static function stone(BigDecimal|int|float|string $value): self
    {
        return self::stones($value);
    }

    public static function tonnes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Tonnes::make());
    }

    public static function tonne(BigDecimal|int|float|string $value): self
    {
        return self::tonnes($value);
    }

    // END_TYPED_FACTORIES
    public function toMicrograms(): self
    {
        return $this->scaleTo(Micrograms::make());
    }

    public function toMilligrams(): self
    {
        return $this->scaleTo(Milligrams::make());
    }

    public function toGrams(): self
    {
        return $this->scaleTo(Grams::make());
    }

    public function toKilograms(): self
    {
        return $this->scaleTo(Kilograms::make());
    }

    public function toTonnes(): self
    {
        return $this->scaleTo(Tonnes::make());
    }

    public function toPounds(): self
    {
        return $this->scaleTo(Pounds::make());
    }

    public function toOunces(): self
    {
        return $this->scaleTo(Ounces::make());
    }

    public function toStones(): self
    {
        return $this->scaleTo(Stones::make());
    }

    // ---------------------------------------------------------------
    // Cross-dimensional operations
    // ---------------------------------------------------------------

    /**
     * @psalm-suppress ImpureMethodCall
     */
    public function timesAcceleration(Acceleration $acceleration): Force
    {
        $base = $this->toBaseValue()->multipliedBy($acceleration->toBaseValue());
        return Force::newtons($base);
    }

    /**
     * @psalm-suppress ImpureMethodCall
     */
    public function timesVelocity(Velocity $velocity): Momentum
    {
        $base = $this->toBaseValue()->multipliedBy($velocity->toBaseValue());
        return Momentum::kilogramMetersPerSecond($base);
    }

    /**
     * @psalm-suppress ImpureMethodCall
     */
    public function dividedByVolume(Volume $volume): Density
    {
        $base = $this->toBaseValue()->dividedBy($volume->toBaseValue(), 20, RoundingMode::HALF_UP);
        return Density::kilogramsPerCubicMeter($base);
    }

    /**
     * @psalm-suppress ImpureMethodCall
     */
    public function dividedByTime(Time $time): MassFlow
    {
        $base = $this->toBaseValue()->dividedBy($time->toBaseValue(), 20, RoundingMode::HALF_UP);
        return MassFlow::kilogramsPerSecond($base);
    }
}
