<?php

declare(strict_types=1);

namespace Monadial\Siphon\Parsing;

use Brick\Math\BigDecimal;
use Fp\Functional\Either\Either;
use Fp\Functional\Option\Option;
use Monadial\Siphon\Exception\UnitNotFound;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\UnitOfMeasure;

/**
 * FP-based quantity parsing pipeline.
 *
 * Parses strings like "100 km/h", "2.5 mega joules", "50kWh" into
 * typed Quantity instances using Either for error handling.
 */
final class QuantityParser
{
    private const string VALUE_PATTERN = '/^\s*([+\-]?(?:\d+(?:\.\d+)?|\.\d+)(?:[eE][+\-]?\d+)?)\s*(.+?)\s*$/';

    /**
     * Parse an input string into a Quantity of the given class.
     *
     * @template T of Quantity
     * @param class-string<T> $quantityClass
     * @return Either<string, T>
     * @throws UnitNotFound
     */
    public static function parse(string $input, string $quantityClass): Either
    {
        $registry = UnitRegistry::forQuantity($quantityClass);

        return self::splitValueAndUnit($input)
            ->flatMap(
                /**
                 * @param array{BigDecimal, string} $parts
                 * @return Either<string, T>
                 */
                static fn (array $parts): Either => self::resolveFromRegistry($parts[1], $registry, $quantityClass)
                    ->map(
                        /**
                         * @return T
                         */
                        static fn (UnitOfMeasure $unit): Quantity => new $quantityClass($parts[0], $unit),
                    ),
            );
    }

    /**
     * Split input into numeric value and unit token.
     *
     * @return Either<string, array{BigDecimal, string}>
     */
    private static function splitValueAndUnit(string $input): Either
    {
        if (!preg_match(self::VALUE_PATTERN, $input, $m)) {
            /** @var Either<string, array{BigDecimal, string}> $left */
            $left = Either::left(sprintf('Unable to parse quantity from "%s"', $input));

            return $left;
        }

        /** @var Either<string, array{BigDecimal, string}> $right */
        $right = Either::right([BigDecimal::of($m[1]), UnitRegistry::normalizeToken($m[2])]);

        return $right;
    }

    /**
     * Resolve a unit token against a pre-loaded registry.
     *
     * @param array<string, class-string<UnitOfMeasure>> $registry
     * @return Either<string, UnitOfMeasure>
     */
    private static function resolveFromRegistry(string $unitToken, array $registry, string $quantityClass): Either
    {
        return Option::fromNullable($registry[$unitToken] ?? null)
            ->map(
                /**
                 * @param class-string<UnitOfMeasure> $unitClass
                 */
                static fn (string $unitClass): UnitOfMeasure => $unitClass::make(),
            )
            ->toRight(static fn (): string => sprintf('Unknown unit "%s" for quantity %s', $unitToken, $quantityClass));
    }
}
