<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Space;

use Monadial\Siphon\Space\Length;
use Monadial\Siphon\Space\Volume;
use Monadial\Siphon\Space\Volume\CubicMeters;
use PHPUnit\Framework\TestCase;

final class LengthTest extends TestCase
{
    public function testCreateValuesFromProperlyFormattedStrings(): void
    {
        self::assertTrue(Length::fromString('10.33 m')->get()->equals(Length\Meters::fromString('10.33')));
        self::assertTrue(Length::fromString('10.33 Å')->get()->equals(Length\Angstroms::fromString('10.33')));
        self::assertTrue(Length::fromString('10.33 nm')->get()->equals(Length\Nanometers::fromString('10.33')));
        self::assertTrue(Length::fromString('10.33 µm')->get()->equals(Length\Microns::fromString('10.33')));
        self::assertTrue(Length::fromString('10.33 mm')->get()->equals(Length\Millimeters::fromString('10.33')));
        self::assertTrue(Length::fromString('10.33 cm')->get()->equals(Length\Centimeters::fromString('10.33')));
        self::assertTrue(Length::fromString('10.33 dm')->get()->equals(Length\Decimeters::fromString('10.33')));
        self::assertTrue(Length::fromString('10.33 dam')->get()->equals(Length\Decameters::fromString('10.33')));
        self::assertTrue(Length::fromString('10.33 hm')->get()->equals(Length\Hectometers::fromString('10.33')));
        self::assertTrue(Length::fromString('10.33 km')->get()->equals(Length\Kilometers::fromString('10.33')));
    }

    public function testStringFormattingOfAllSupportedUnitsOfMeasure(): void
    {
        self::assertSame('1 m', (string) Length\Meters::fromInt(1));
        self::assertSame('1 Å', (string) Length\Angstroms::fromInt(1));
        self::assertSame('1 nm', (string) Length\Nanometers::fromInt(1));
        self::assertSame('1 µm', (string) Length\Microns::fromInt(1));
        self::assertSame('1 mm', (string) Length\Millimeters::fromInt(1));
        self::assertSame('1 cm', (string) Length\Centimeters::fromInt(1));
        self::assertSame('1 dm', (string) Length\Decimeters::fromInt(1));
        self::assertSame('1 dam', (string) Length\Decameters::fromInt(1));
        self::assertSame('1 hm', (string) Length\Hectometers::fromInt(1));
        self::assertSame('1 km', (string) Length\Kilometers::fromInt(1));
    }

    public function testReturnVolumeWhenMeterIsCubed(): void
    {
        Length\Meters::fromInt(3)->cubed()->equals(Volume\CubicMeters::fromInt(27));
    }
}
