<?php

declare(strict_types=1);

namespace Monadial\Siphon\Space;

use Brick\Math\BigDecimal;
use Fp\Collections\ArrayList;
use Fp\Functional\Option\Option;
use Monadial\Siphon\Dimension;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Space\Length\Angstroms;
use Monadial\Siphon\Space\Length\Centimeters;
use Monadial\Siphon\Space\Length\Decameters;
use Monadial\Siphon\Space\Length\Decimeters;
use Monadial\Siphon\Space\Length\Hectometers;
use Monadial\Siphon\Space\Length\Kilometers;
use Monadial\Siphon\Space\Length\Meters;
use Monadial\Siphon\Space\Length\Microns;
use Monadial\Siphon\Space\Length\Millimeters;
use Monadial\Siphon\Space\Length\Nanometers;
use Monadial\Siphon\UnitOfMeasure;
use Stringable;

use function Fp\Util\regExpMatch;

/**
 * @internal This class is internal to Siphon and should not be used in third-party code.
 * @template-extends Dimension<Length>
 */
final readonly class LengthDimension extends Dimension
{
    /**
     * @return Option<Quantity>
     */
    public static function fromString(Stringable|string $input): Option
    {
        return Option::do(static function () use ($input) {
            $value = yield regExpMatch(self::regex(), (string) $input, 1)
                ->map(static fn (string $v) => BigDecimal::of($v));

            $symbol = yield regExpMatch(self::regex(), (string) $input, 2)
                ->flatMap(static fn (string $s) => self::unitIndex()->get($s));

            return self::apply($value, $symbol);
        });
    }

    protected static function units(): ArrayList
    {
        return ArrayList::collect([
            Angstroms::make(),
            Centimeters::make(),
            Decameters::make(),
            Decimeters::make(),
            Hectometers::make(),
            Kilometers::make(),
            Meters::make(),
            Microns::make(),
            Millimeters::make(),
            Nanometers::make(),
        ]);
    }

    protected static function regex(): string
    {
        return sprintf(
            '/^([-+]?\d*\.?\d+(?:[eE][-+]?\d+)?)\s*(%s)$/u',
            self::unitIndex()->keys()->mkString(sep: '|')
        );
    }

    protected static function baseUnit(): UnitOfMeasure
    {
        return Meters::make();
    }

    protected static function quantity(): string
    {
        return Length::class;
    }
}
