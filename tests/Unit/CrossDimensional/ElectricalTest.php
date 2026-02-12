<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Unit\CrossDimensional;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\UnitOfMeasure;
use Monadial\Siphon\Unit\Electrical\ElectricCharge;
use Monadial\Siphon\Unit\Electrical\ElectricChargeUnit;
use Monadial\Siphon\Unit\Electrical\ElectricCharge\Coulombs;
use Monadial\Siphon\Unit\Electrical\ElectricCurrent;
use Monadial\Siphon\Unit\Electrical\ElectricCurrentUnit;
use Monadial\Siphon\Unit\Electrical\ElectricCurrent\Amperes;
use Monadial\Siphon\Unit\Electrical\ElectricPotential;
use Monadial\Siphon\Unit\Electrical\ElectricPotentialUnit;
use Monadial\Siphon\Unit\Electrical\ElectricPotential\Volts;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance;
use Monadial\Siphon\Unit\Electrical\ElectricalResistanceUnit;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance\Ohms;
use Monadial\Siphon\Unit\Mechanics\Power;
use Monadial\Siphon\Unit\Mechanics\PowerUnit;
use Monadial\Siphon\Unit\Mechanics\Power\Watts;
use Monadial\Siphon\Unit\Time\Time;
use Monadial\Siphon\Unit\Time\TimeUnit;
use Monadial\Siphon\Unit\Time\Time\Seconds;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ElectricPotential::class)]
#[CoversClass(ElectricCurrent::class)]
#[CoversClass(Quantity::class)]
#[UsesClass(UnitOfMeasure::class)]
#[UsesClass(MetricSystem::class)]
#[UsesClass(ElectricPotentialUnit::class)]
#[UsesClass(ElectricCurrentUnit::class)]
#[UsesClass(ElectricalResistanceUnit::class)]
#[UsesClass(ElectricChargeUnit::class)]
#[UsesClass(PowerUnit::class)]
#[UsesClass(TimeUnit::class)]
#[UsesClass(Volts::class)]
#[UsesClass(Amperes::class)]
#[UsesClass(Ohms::class)]
#[UsesClass(Coulombs::class)]
#[UsesClass(Watts::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(Power::class)]
#[UsesClass(ElectricalResistance::class)]
#[UsesClass(ElectricCharge::class)]
#[UsesClass(Time::class)]
final class ElectricalTest extends TestCase
{
    // ---------------------------------------------------------------
    // P = V × I (Power = Voltage × Current)
    // ---------------------------------------------------------------

    public function testVoltageTimesCurrentGivesPower(): void
    {
        // 230V × 10A = 2300W
        $voltage = ElectricPotential::volts(230);
        $current = ElectricCurrent::amperes(10);
        $power = $voltage->timesCurrent($current);

        self::assertInstanceOf(Power::class, $power);
        self::assertInstanceOf(Watts::class, $power->uom());
        self::assertEqualsWithDelta(2300.0, (float) (string) $power->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // V = I × R (Ohm's law)
    // ---------------------------------------------------------------

    public function testCurrentTimesResistanceGivesVoltage(): void
    {
        // 5A × 100Ω = 500V
        $current = ElectricCurrent::amperes(5);
        $resistance = ElectricalResistance::ohms(100);
        $voltage = $current->timesResistance($resistance);

        self::assertInstanceOf(ElectricPotential::class, $voltage);
        self::assertInstanceOf(Volts::class, $voltage->uom());
        self::assertEqualsWithDelta(500.0, (float) (string) $voltage->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // Q = I × t (Charge = Current × Time)
    // ---------------------------------------------------------------

    public function testCurrentTimesTimeGivesCharge(): void
    {
        // 2A × 3600s = 7200C
        $current = ElectricCurrent::amperes(2);
        $time = Time::seconds(3600);
        $charge = $current->timesTime($time);

        self::assertInstanceOf(ElectricCharge::class, $charge);
        self::assertInstanceOf(Coulombs::class, $charge->uom());
        self::assertEqualsWithDelta(7200.0, (float) (string) $charge->value(), 0.0001);
    }

    // ---------------------------------------------------------------
    // P = I² × R (via chain: V = I×R, P = V×I)
    // ---------------------------------------------------------------

    public function testPowerFromCurrentAndResistance(): void
    {
        // I=3A, R=10Ω → V=30V → P=30V×3A=90W
        $current = ElectricCurrent::amperes(3);
        $resistance = ElectricalResistance::ohms(10);

        $voltage = $current->timesResistance($resistance);
        $power = $voltage->timesCurrent($current);

        self::assertEqualsWithDelta(90.0, (float) (string) $power->value(), 0.0001);
    }
}
