# Siphon (`monadial/php-si`)

Type-safe SI units for PHP 8.4+ with arbitrary-precision arithmetic.

Siphon provides immutable, generic quantity and unit-of-measure abstractions backed by `brick/math` for exact decimal arithmetic. Convert between units, perform cross-dimensional calculations (F=ma, P=IV, v=d/t, ...), price physical quantities, and handle money -- all without floating-point surprises.

## Installation

```bash
composer require monadial/php-si
```

**Requirements:** PHP >= 8.4, ext-bcmath

## Quick Start

```php
use Monadial\Siphon\Unit\Space\Length;
use Monadial\Siphon\Unit\Motion\Velocity;
use Monadial\Siphon\Unit\Time\Time;

// Unit conversion
$marathon = Length::kilometers('42.195');
echo $marathon->toMiles(); // 26.21875... mi

// Cross-dimensional: v = d / t
$distance = Length::meters(100);
$time     = Time::seconds('9.58');
$speed    = $distance->dividedByTime($time);
echo $speed->toKilometersPerHour(); // ~37.58 km/h

// Arithmetic
$total = Length::meters(10)->plus(Length::centimeters(50)); // 10.5 m
```

## Core Concepts

### Quantity

`Quantity<TUoM>` is the abstract base for every measurable value. It holds an arbitrary-precision `BigDecimal` and a typed unit. All quantities are `readonly` and immutable.

```php
// Construction
$length = Length::meters(100);              // named factory
$length = Length::from(100, Meters::make()); // generic factory
$length = Length::parse('100 m');            // string parsing

// Access
$length->value();  // BigDecimal
$length->uom();    // Meters instance
```

### UnitOfMeasure

Each unit is a `readonly` singleton with a `factor()` (conversion multiplier relative to the base unit) and a `symbol()`.

```php
use Monadial\Siphon\Unit\Space\Length\Kilometers;

$km = Kilometers::make();
$km->factor();  // BigDecimal("1000")
$km->symbol();  // "km"
```

### Systems

`MetricSystem` enum provides all SI prefixes (YOCTO through YOTTA) as factor multipliers:

```php
use Monadial\Siphon\System\MetricSystem;

MetricSystem::KILO->factor();  // BigDecimal("1000")
MetricSystem::MILLI->factor(); // BigDecimal("0.001")
```

## Supported Dimensions & Units

27 physical dimensions with 247+ concrete units across 8 domains.

| Domain | Dimension | Units |
|--------|-----------|-------|
| **Space** | Length | m, km, cm, mm, µm, nm, dm, dam, hm, ft, in, yd, mi, nmi, AU, ly |
| | Area | m², km², cm², mm², ft², in², yd², mi², acres, hectares, barns |
| | Volume | m³, cm³, ft³, in³, yd³, L, mL, cL, dL, hL, US gal, US pt, US qt, US cup, imp gal, fl oz, tbsp, tsp |
| | Angle | rad, deg, grad, turn, arcmin, arcsec |
| | Solid Angle | sr, deg² |
| **Mass** | Mass | kg, g, mg, µg, t, lb, oz, st |
| **Time** | Time | s, ms, µs, ns, min, h, d, wk, mo, yr |
| | Frequency | Hz, kHz, MHz, GHz, THz, RPM |
| **Motion** | Velocity | m/s, km/h, km/s, ft/s, mph, mm/s, kn |
| | Acceleration | m/s², ft/s², g |
| **Mechanics** | Force | N, kN, MN, mN, dyn, kgf, lbf |
| | Energy | J, kJ, MJ, GJ, mJ, eV, cal, kcal, BTU, Wh, kWh, MWh, GWh |
| | Power | W, kW, MW, GW, mW, hp, BTU/h |
| | Pressure | Pa, kPa, MPa, bar, mbar, atm, psi, mmHg, Torr |
| | Torque | N·m, lb·ft |
| | Momentum | kg·m/s, N·s |
| | Density | kg/m³, g/cm³, g/L |
| | Mass Flow | kg/s, kg/h, lb/s |
| | Volume Flow | m³/s, L/s, L/min, gpm |
| **Electrical** | Current | A, kA, mA, µA |
| | Potential | V, kV, MV, mV, µV |
| | Resistance | Ω, kΩ, MΩ, GΩ, mΩ, µΩ, nΩ |
| | Capacitance | F, kF, mF, µF, nF, pF |
| | Charge | C, mC, µC, nC, pC, Ah, mAh |
| | Inductance | H, mH, µH, nH |
| | Conductance | S, mS, µS |
| | Magnetic Flux | Wb, mWb, µWb |
| | Flux Density | T, mT, µT, G |
| **Light** | Luminous Flux | lm, klm, mlm |
| | Luminous Intensity | cd, kcd, mcd |
| **Information** | Information | B, b, KB, MB, GB, TB, PB, EB, KiB, MiB, GiB, TiB, PiB, EiB |
| | Data Rate | B/s, b/s, KB/s, MB/s, GB/s, TB/s, kb/s, Mb/s, Gb/s |
| **Substance** | Amount | mol, mmol, µmol, kmol |
| **Temperature** | Temperature | K, kK, mK, °C, °F, °R |
| **Dimensionless** | Dimensionless | ea, doz, gross, score, % |

## API Reference

### Construction

```php
// Named factories (singular and plural)
$v = Velocity::metersPerSecond(10);
$v = Velocity::knot(1);

// Generic factory
$v = Velocity::from(10, MetersPerSecond::make());

// Conversion factory
$v = Velocity::convert(100, KilometersPerHour::make(), MetersPerSecond::make());

// String parsing
$v = Velocity::parse('100 km/h');
```

### Unit Conversion

```php
$speed = Velocity::kilometersPerHour(100);

// scaleTo / in — returns a new Quantity in the target unit
$speed->scaleTo(MetersPerSecond::make());  // 27.7... m/s
$speed->in(MetersPerSecond::make());       // alias

// to — extracts the numeric BigDecimal in the target unit
$speed->to(MetersPerSecond::make());       // BigDecimal("27.77...")

// Named conversion methods
$speed->toMetersPerSecond();
$speed->toMilesPerHour();
$speed->toKnots();
```

### Arithmetic

All arithmetic is same-unit aware: `plus`/`minus` auto-convert the operand to the receiver's unit.

```php
$a = Length::meters(10);
$b = Length::centimeters(50);

$a->plus($b);         // 10.5 m
$a->minus($b);        // 9.5 m
$a->times(3);         // 30 m       (scalar multiply)
$a->dividedBy(2);     // 5 m        (scalar divide)
$a->negate();          // -10 m
$a->abs();             // 10 m
```

### Comparisons

```php
$a = Length::meters(1000);
$b = Length::kilometers(1);

$a->isEqualTo($b);              // true  (cross-unit comparison)
$a->isGreaterThan($b);          // false
$a->isLessThan($b);             // false
$a->isGreaterThanOrEqualTo($b); // true
$a->isLessThanOrEqualTo($b);    // true

// Approximate equality
$a->approx($b, Length::millimeters(1)); // true (within 1mm)

// Min / Max
$a->min(Length::meters(500), Length::meters(2000)); // 500 m
$a->max(Length::meters(500), Length::meters(2000)); // 2000 m
```

### Transformation

```php
// Apply arbitrary function to the value, preserving type and unit
$rounded = Length::meters('3.14159')->map(
    fn(BigDecimal $v) => $v->toScale(2, RoundingMode::HALF_UP)
); // 3.14 m
```

## Cross-Dimensional Operations

Siphon provides ~60 typed methods for physics equations. Each method converts both operands to base units, performs the calculation, and returns the result in the appropriate base unit.

### Complete Reference

#### Mechanics

| Operation | Method | Formula |
|-----------|--------|---------|
| `Mass × Acceleration` | `$mass->timesAcceleration($a)` | F = ma |
| `Force ÷ Mass` | `$force->dividedByMass($m)` | a = F/m |
| `Force ÷ Acceleration` | `$force->dividedByAcceleration($a)` | m = F/a |
| `Force × Length` | `$force->timesLength($d)` | W = Fd |
| `Energy ÷ Length` | `$energy->dividedByLength($d)` | F = W/d |
| `Energy ÷ Force` | `$energy->dividedByForce($f)` | d = W/F |
| `Energy ÷ Time` | `$energy->dividedByTime($t)` | P = E/t |
| `Energy ÷ Power` | `$energy->dividedByPower($p)` | t = E/P |
| `Energy ÷ Volume` | `$energy->dividedByVolume($v)` | P = E/V |
| `Power × Time` | `$power->timesTime($t)` | E = Pt |
| `Force × Velocity` | `$force->timesVelocity($v)` | P = Fv |
| `Power ÷ Force` | `$power->dividedByForce($f)` | v = P/F |
| `Power ÷ Velocity` | `$power->dividedByVelocity($v)` | F = P/v |
| `Pressure × Area` | `$pressure->timesArea($a)` | F = PA |
| `Force ÷ Area` | `$force->dividedByArea($a)` | P = F/A |
| `Pressure × Volume` | `$pressure->timesVolume($v)` | E = PV |
| `Mass × Velocity` | `$mass->timesVelocity($v)` | p = mv |
| `Momentum ÷ Mass` | `$momentum->dividedByMass($m)` | v = p/m |
| `Momentum ÷ Velocity` | `$momentum->dividedByVelocity($v)` | m = p/v |
| `Momentum ÷ Time` | `$momentum->dividedByTime($t)` | F = Δp/Δt |
| `Torque ÷ Force` | `$torque->dividedByForce($f)` | d = τ/F |
| `Torque ÷ Length` | `$torque->dividedByLength($d)` | F = τ/d |
| `Mass ÷ Volume` | `$mass->dividedByVolume($v)` | ρ = m/V |
| `Density × Volume` | `$density->timesVolume($v)` | m = ρV |
| `Mass ÷ Density` | `$mass->dividedByDensity($ρ)` | V = m/ρ |
| `Mass ÷ Time` | `$mass->dividedByTime($t)` | ṁ = m/t |
| `MassFlow × Time` | `$flow->timesTime($t)` | m = ṁt |

#### Space & Motion

| Operation | Method | Formula |
|-----------|--------|---------|
| `Length × Length` | `$l->timesLength($l2)` | A = l×w |
| `Length × Area` | `$l->timesArea($a)` | V = l×A |
| `Area × Length` | `$a->timesLength($l)` | V = A×l |
| `Velocity × Time` | `$v->timesTime($t)` | d = vt |
| `Length ÷ Time` | `$d->dividedByTime($t)` | v = d/t |
| `Velocity ÷ Time` | `$v->dividedByTime($t)` | a = Δv/Δt |
| `Acceleration × Time` | `$a->timesTime($t)` | v = at |
| `Volume ÷ Time` | `$v->dividedByTime($t)` | Q̇ = V/t |
| `VolumeFlow × Time` | `$q->timesTime($t)` | V = Q̇t |
| `Volume ÷ VolumeFlow` | `$v->dividedByVolumeFlow($q)` | t = V/Q̇ |

#### Electrical

| Operation | Method | Formula |
|-----------|--------|---------|
| `Voltage × Current` | `$v->timesCurrent($i)` | P = VI |
| `Power ÷ Current` | `$p->dividedByCurrent($i)` | V = P/I |
| `Power ÷ Voltage` | `$p->dividedByPotential($v)` | I = P/V |
| `Current × Resistance` | `$i->timesResistance($r)` | V = IR |
| `Resistance × Current` | `$r->timesCurrent($i)` | V = IR |
| `Voltage ÷ Current` | `$v->dividedByCurrent($i)` | R = V/I |
| `Voltage ÷ Resistance` | `$v->dividedByResistance($r)` | I = V/R |
| `Current × Time` | `$i->timesTime($t)` | Q = It |
| `Charge ÷ Time` | `$q->dividedByTime($t)` | I = Q/t |
| `Charge ÷ Current` | `$q->dividedByCurrent($i)` | t = Q/I |
| `Charge ÷ Capacitance` | `$q->dividedByCapacitance($c)` | V = Q/C |
| `Capacitance × Voltage` | `$c->timesPotential($v)` | Q = CV |

#### Information

| Operation | Method | Formula |
|-----------|--------|---------|
| `Information ÷ Time` | `$data->dividedByTime($t)` | rate = data/t |
| `Information ÷ DataRate` | `$data->dividedByDataRate($r)` | t = data/rate |
| `DataRate × Time` | `$rate->timesTime($t)` | data = rate×t |

## Money, Price & Exchange Rates

### Money

Immutable wrapper around `brick/money` with arbitrary-precision arithmetic.

```php
use Monadial\Siphon\Market\Money;

$price = Money::usd('49.99');
$tax   = $price->times('0.21');        // $10.4979
$total = $price->plus($tax);           // $60.4879

// Currency-specific factories
$eur = Money::eur(100);
$gbp = Money::gbp('29.99');

// From string
$parsed = Money::parse('50.00 USD');

// Allocation
[$a, $b, $c] = Money::usd(100)->split(3);       // Fair 3-way split
[$x, $y]     = Money::usd(100)->allocate(70, 30); // 70/30 split
```

### Price per Quantity

Attach a monetary price to any physical quantity:

```php
use Monadial\Siphon\Market\Money;
use Monadial\Siphon\Market\Price;
use Monadial\Siphon\Unit\Mechanics\Energy;

// Electricity: $0.12 per kWh
$rate  = Money::usd('0.12')->per(Energy::kilowattHours(1));
$usage = Energy::kilowattHours(350);
$bill  = $rate->times($usage); // $42.00

echo $rate; // "0.12 USD/kWh"
```

### Exchange Rates

```php
use Monadial\Siphon\Market\ExchangeRate;

$rate = new ExchangeRate('USD', 'EUR', '0.92');
$eur  = $rate->convert(Money::usd(100)); // 92.00 EUR

$inverse = $rate->inverse(); // EUR → USD at 1/0.92
```

## Practical Examples

### Electricity Billing

```php
$power    = Power::kilowatts('2.5');
$duration = Time::hours(8);
$energy   = $power->timesTime($duration);        // -> Energy in joules
$kwh      = $energy->toKilowattHours();           // 20 kWh

$rate = Money::usd('0.12')->per(Energy::kilowattHours(1));
$cost = $rate->times($kwh);                       // $2.40
```

### Data Transfer Estimation

```php
$fileSize  = Information::gigabytes(50);
$bandwidth = DataRate::megabytesPerSecond(100);
$time      = $fileSize->dividedByDataRate($bandwidth);  // -> Time
echo $time->toMinutes(); // ~8.33 min
```

### Tank Fill Time

```php
$tankVolume = Volume::litres(1000);
$flowRate   = VolumeFlow::litresPerMinute(25);
$fillTime   = $tankVolume->dividedByVolumeFlow($flowRate); // -> Time
echo $fillTime->toMinutes(); // 40 min
```

### Circuit Analysis (Ohm's Law)

```php
$voltage    = ElectricPotential::volts(230);
$resistance = ElectricalResistance::ohms(100);
$current    = $voltage->dividedByResistance($resistance); // I = V/R -> 2.3 A
$power      = $voltage->timesCurrent($current);            // P = VI -> 529 W
```

### Material Science

```php
$density = Density::kilogramsPerCubicMeter(7874);  // Iron
$mass    = Mass::kilograms(500);
$volume  = $mass->dividedByDensity($density);       // V = m/rho -> 0.0635 m^3
echo $volume->toLitres();                            // ~63.5 L
```

### Newtonian Mechanics Chain

```php
$mass     = Mass::kilograms(10);
$accel    = Acceleration::metersPerSecondSquared('9.81');
$distance = Length::meters(100);
$time     = Time::seconds(10);

$force  = $mass->timesAcceleration($accel);   // F = ma  -> 98.1 N
$energy = $force->timesLength($distance);     // W = Fd  -> 9810 J
$power  = $energy->dividedByTime($time);      // P = E/t -> 981 W
```

## Development

### Setup

```bash
git clone https://github.com/monadial/php-si.git
cd php-si
composer install
```

### Docker

```bash
docker-compose up -d
docker exec -it php-siphon-84 bash
```

### Testing & Quality

```bash
composer phpunit          # Run tests (PHPUnit 12, strict mode)
composer phpstan          # Static analysis (max level, ShipMonk rules)
composer phpcs            # Code style (pixelfederation standards)
composer phpcbf           # Auto-fix code style
```

All quality gates run automatically on `git commit` via GrumPHP.

## License

MIT
