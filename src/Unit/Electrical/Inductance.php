<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Brick\Math\BigDecimal;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Electrical\Inductance\Henrys;
use Monadial\Siphon\Unit\Electrical\Inductance\Microhenrys;
use Monadial\Siphon\Unit\Electrical\Inductance\Millihenrys;
use Monadial\Siphon\Unit\Electrical\Inductance\Nanohenrys;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<InductanceUnit>
 */
final readonly class Inductance extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function henrys(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Henrys::make());
    }

    public static function henry(BigDecimal|int|float|string $value): self
    {
        return self::henrys($value);
    }

    public static function microhenrys(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Microhenrys::make());
    }

    public static function microhenry(BigDecimal|int|float|string $value): self
    {
        return self::microhenrys($value);
    }

    public static function millihenrys(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Millihenrys::make());
    }

    public static function millihenry(BigDecimal|int|float|string $value): self
    {
        return self::millihenrys($value);
    }

    public static function nanohenrys(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Nanohenrys::make());
    }

    public static function nanohenry(BigDecimal|int|float|string $value): self
    {
        return self::nanohenrys($value);
    }

    // END_TYPED_FACTORIES
    public function toNanohenrys(): self
    {
        return $this->scaleTo(Nanohenrys::make());
    }

    public function toMicrohenrys(): self
    {
        return $this->scaleTo(Microhenrys::make());
    }

    public function toMillihenrys(): self
    {
        return $this->scaleTo(Millihenrys::make());
    }

    public function toHenrys(): self
    {
        return $this->scaleTo(Henrys::make());
    }
}
