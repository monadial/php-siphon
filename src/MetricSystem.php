<?php

declare(strict_types=1);

namespace Monadial\Siphon;

use Brick\Math\BigDecimal;
use Override;

enum MetricSystem implements System
{
    case YOCTO;
    case ZEPTO;
    case ATTO;
    case FEMTO;
    case PICO;
    case NANO;
    case MICRO;
    case MILLI;
    case CENTI;
    case DECI;
    case BASE;
    case DECA;
    case HECTO;
    case KILO;
    case MEGA;
    case GIGA;
    case TERA;
    case PETA;
    case EXA;
    case ZETTA;
    case YOTTA;

    private const float YOCTO_MULTIPLIER = 1e-24;
    private const float ZEPTO_MULTIPLIER = 1e-21;
    private const float ATTO_MULTIPLIER = 1e-18;
    private const float FEMTO_MULTIPLIER = 1e-15;
    private const float PICO_MULTIPLIER = 1e-12;
    private const float NANO_MULTIPLIER = 1e-9;
    private const float MICRO_MULTIPLIER = 1e-6;
    private const float MILLI_MULTIPLIER = 1e-3;
    private const float CENTI_MULTIPLIER = 1e-2;
    private const float DECI_MULTIPLIER = 1e-1;

    private const float BASE_MULTIPLIER = 1;

    private const float DECA_MULTIPLIER = 1e1;
    private const float HECTO_MULTIPLIER = 1e2;
    private const float KILO_MULTIPLIER = 1e3;
    private const float MEGA_MULTIPLIER = 1e6;
    private const float GIGA_MULTIPLIER = 1e9;
    private const float TERA_MULTIPLIER = 1e12;
    private const float PETA_MULTIPLIER = 1e15;
    private const float EXA_MULTIPLIER = 1e18;
    private const float ZETTA_MULTIPLIER = 1e21;
    private const float YOTTA_MULTIPLIER = 1e24;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(match ($this) {
            self::YOCTO => self::YOCTO_MULTIPLIER,
            self::ZEPTO => self::ZEPTO_MULTIPLIER,
            self::ATTO => self::ATTO_MULTIPLIER,
            self::FEMTO => self::FEMTO_MULTIPLIER,
            self::PICO => self::PICO_MULTIPLIER,
            self::NANO => self::NANO_MULTIPLIER,
            self::MICRO => self::MICRO_MULTIPLIER,
            self::MILLI => self::MILLI_MULTIPLIER,
            self::CENTI => self::CENTI_MULTIPLIER,
            self::DECI => self::DECI_MULTIPLIER,
            self::BASE => self::BASE_MULTIPLIER,
            self::DECA => self::DECA_MULTIPLIER,
            self::HECTO => self::HECTO_MULTIPLIER,
            self::KILO => self::KILO_MULTIPLIER,
            self::MEGA => self::MEGA_MULTIPLIER,
            self::GIGA => self::GIGA_MULTIPLIER,
            self::TERA => self::TERA_MULTIPLIER,
            self::PETA => self::PETA_MULTIPLIER,
            self::EXA => self::EXA_MULTIPLIER,
            self::ZETTA => self::ZETTA_MULTIPLIER,
            self::YOTTA => self::YOTTA_MULTIPLIER,
        });
    }
}
