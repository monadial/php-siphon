<?php

declare(strict_types=1);

namespace Monadial\Siphon;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use LogicException;

/**
 * @psalm-consistent-constructor
 * @psalm-immutable
 * @template-covariant TUoM of UnitOfMeasure
 */
abstract readonly class Quantity
{
    /**
     * @psalm-api
     * @param BigDecimal|int|float|string $value
     * @param TUoM $uom
     * @return static
     */
    public static function from(BigDecimal|int|float|string $value, UnitOfMeasure $uom): static
    {
        /** @psalm-suppress UnsafeGenericInstantiation */
        return new static(BigDecimal::of($value), $uom);
    }

    /**
     * @psalm-api
     * @param BigDecimal|int|float|string $value
     * @param TUoM $from
     * @param TUoM $to
     * @return static
     */
    public static function convert(
        BigDecimal|int|float|string $value,
        UnitOfMeasure $from,
        UnitOfMeasure $to,
    ): static {
        return self::from($value, $from)->scaleTo($to);
    }

    public static function parse(string $input): static
    {
        if (!preg_match('/^\s*([+\-]?(?:\d+(?:\.\d+)?|\.\d+)(?:[eE][+\-]?\d+)?)\s*(.+?)\s*$/', $input, $m)) {
            throw new LogicException(sprintf('Unable to parse quantity from "%s"', $input));
        }

        $value = BigDecimal::of($m[1]);
        $unitToken = self::normalizeToken($m[2]);
        $unitMap = self::unitAliasesForStaticClass();

        if (!array_key_exists($unitToken, $unitMap)) {
            throw new LogicException(sprintf('Unknown unit "%s" for quantity %s', $m[2], static::class));
        }

        /** @var class-string<UnitOfMeasure> $unitClass */
        $unitClass = $unitMap[$unitToken];

        /** @psalm-suppress UnsafeGenericInstantiation */
        return new static($value, $unitClass::make());
    }

    /**
     * @param TUoM $uom
     */
    public function __construct(
        protected BigDecimal $value,
        protected UnitOfMeasure $uom,
    ) {
    }

    /**
     * @psalm-api
     */
    public function value(): BigDecimal
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value . ' ' . $this->uom->symbol();
    }

    public function toScientificString(int $precision = 6): string
    {
        return sprintf('%.' . $precision . 'E %s', (float) (string) $this->value, $this->uom->symbol());
    }

    /**
     * @psalm-api
     * @return TUoM
     */
    public function uom(): UnitOfMeasure
    {
        return $this->uom;
    }

    /**
     * @param TUoM $uom
     * @return static
     */
    public function scaleTo(UnitOfMeasure $uom): static
    {
        /** @psalm-suppress ImpureMethodCall */
        return match (true) {
            $uom->equals($this->uom) => $this->with($this->value, $uom),
            default => $this->with(
                $this->value
                    ->plus($this->uom->offset())
                    ->multipliedBy($this->uom->factor())
                    ->dividedBy($uom->factor(), max($this->value->getScale(), 10) + 10, RoundingMode::HALF_UP)
                    ->minus($uom->offset()),
                $uom,
            ),
        };
    }

    /**
     * @psalm-pure
     * @return static
     */
    private function with(BigDecimal $value, UnitOfMeasure $uom): static
    {
        /** @psalm-suppress UnsafeGenericInstantiation */
        return new static($value, $uom);
    }

    /**
     * @return array<string, class-string<UnitOfMeasure>>
     */
    private static function unitAliasesForStaticClass(): array
    {
        /** @var array<class-string<self>, array<string, class-string<UnitOfMeasure>>> $cache */
        static $cache = [];

        if (array_key_exists(static::class, $cache)) {
            return $cache[static::class];
        }

        $quantityClassPath = substr(static::class, strlen('Monadial\\Siphon\\'));
        if (!is_string($quantityClassPath) || $quantityClassPath === '') {
            throw new LogicException(sprintf('Unable to infer class path for quantity %s', static::class));
        }

        $unitDir = __DIR__ . '/' . str_replace('\\', '/', $quantityClassPath);
        $unitFiles = glob($unitDir . '/*.php');

        if ($unitFiles === false || $unitFiles === []) {
            throw new LogicException(sprintf('No unit directory found for quantity %s', static::class));
        }

        $map = [];
        foreach ($unitFiles as $unitFile) {
            $shortName = pathinfo($unitFile, PATHINFO_FILENAME);
            $unitClass = static::class . '\\' . $shortName;

            if (!is_a($unitClass, UnitOfMeasure::class, true)) {
                continue;
            }

            /** @var UnitOfMeasure $unit */
            $unit = $unitClass::make();

            foreach ($unit->aliases() as $alias) {
                $map[self::normalizeToken($alias)] = $unitClass;
            }
        }

        $cache[static::class] = $map;

        return $map;
    }

    private static function normalizeToken(string $token): string
    {
        $normalized = strtolower(trim($token));
        $normalized = preg_replace('/\s*\/\s*/', '/', $normalized) ?? $normalized;
        $normalized = preg_replace('/\s+/', ' ', $normalized) ?? $normalized;

        return $normalized;
    }
}
