<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Space\Angle\Arcminutes;
use Monadial\Siphon\Unit\Space\Angle\Arcseconds;
use Monadial\Siphon\Unit\Space\Angle\Degrees;
use Monadial\Siphon\Unit\Space\Angle\Gradians;
use Monadial\Siphon\Unit\Space\Angle\Radians;
use Monadial\Siphon\Unit\Space\Angle\Turns;

/**
 * Angle represents the rotation between two rays sharing a common endpoint (vertex).
 *
 * The SI unit of plane angle is the radian (rad), defined as the angle subtended at
 * the centre of a circle by an arc equal in length to the radius. A full rotation
 * equals 2*pi radians (approximately 6.2832 rad) or 360 degrees.
 *
 * Available units: Radians (rad), Degrees (deg), Arcminutes (arcmin),
 * Arcseconds (arcsec), Gradians (gon), Turns (turn).
 *
 * Usage:
 *     $angle = Angle::degrees(180);
 *     $inRadians = $angle->toRadians(); // ~3.14159 rad
 *     $rightAngle = Angle::turns('0.25'); // 90 degrees
 *
 * @see AngleUnit for the abstract unit base class.
 * @template-extends Quantity<AngleUnit>
 */
final readonly class Angle extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function arcminutes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Arcminutes::make());
    }

    public static function arcminute(BigDecimal|int|float|string $value): self
    {
        return self::arcminutes($value);
    }

    public static function arcseconds(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Arcseconds::make());
    }

    public static function arcsecond(BigDecimal|int|float|string $value): self
    {
        return self::arcseconds($value);
    }

    public static function degrees(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Degrees::make());
    }

    public static function degree(BigDecimal|int|float|string $value): self
    {
        return self::degrees($value);
    }

    public static function gradians(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Gradians::make());
    }

    public static function gradian(BigDecimal|int|float|string $value): self
    {
        return self::gradians($value);
    }

    public static function radians(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Radians::make());
    }

    public static function radian(BigDecimal|int|float|string $value): self
    {
        return self::radians($value);
    }

    public static function turns(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Turns::make());
    }

    public static function turn(BigDecimal|int|float|string $value): self
    {
        return self::turns($value);
    }

    // END_TYPED_FACTORIES
    public function toRadians(): self
    {
        return $this->scaleTo(Radians::make());
    }

    public function toDegrees(): self
    {
        return $this->scaleTo(Degrees::make());
    }

    public function toGradians(): self
    {
        return $this->scaleTo(Gradians::make());
    }

    public function toTurns(): self
    {
        return $this->scaleTo(Turns::make());
    }

    public function toArcminutes(): self
    {
        return $this->scaleTo(Arcminutes::make());
    }

    public function toArcseconds(): self
    {
        return $this->scaleTo(Arcseconds::make());
    }
}
