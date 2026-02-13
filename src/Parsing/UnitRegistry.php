<?php

declare(strict_types=1);

namespace Monadial\Siphon\Parsing;

use Fp\Collections\ArrayList;
use Monadial\Siphon\Exception\UnitNotFound;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\UnitOfMeasure;
use stdClass;
use WeakMap;

/**
 * Discovers unit classes from the filesystem and builds alias→class maps.
 *
 * No hardcoded unit lists — units are discovered dynamically from the
 * directory structure matching the PSR-4 namespace layout.
 */
final class UnitRegistry
{
    /**
     * @var array<string, stdClass>
     */
    private static array $tokens = [];

    /**
     * @var WeakMap<stdClass, array<string, class-string<UnitOfMeasure>>>
     */
    private static WeakMap $registryCache;

    /**
     * @template T of Quantity<UnitOfMeasure>
     * @param class-string<T> $quantityClass
     * @return array<string, class-string<UnitOfMeasure>>
     * @throws UnitNotFound
     */
    public static function forQuantity(string $quantityClass): array
    {
        if (!isset(self::$registryCache)) {
            self::$registryCache = new WeakMap();
        }

        $token = self::tokenFor($quantityClass);

        if (isset(self::$registryCache[$token])) {
            return self::$registryCache[$token];
        }

        $map = self::discoverUnits($quantityClass);
        self::$registryCache[$token] = $map;

        return $map;
    }

    /**
     * Clear all cached registries (useful for testing).
     */
    public static function clear(): void
    {
        self::$tokens = [];
        self::$registryCache = new WeakMap();
    }

    /**
     * Normalize a unit token for lookup.
     */
    public static function normalizeToken(string $token): string
    {
        $normalized = strtolower(trim($token));
        $normalized = preg_replace('/\s*\/\s*/', '/', $normalized) ?? $normalized;

        return preg_replace('/\s+/', ' ', $normalized) ?? $normalized;
    }

    private static function tokenFor(string $quantityClass): stdClass
    {
        return self::$tokens[$quantityClass] ??= new stdClass();
    }

    /**
     * @param class-string<Quantity<UnitOfMeasure>> $quantityClass
     * @return array<string, class-string<UnitOfMeasure>>
     * @throws UnitNotFound
     */
    private static function discoverUnits(string $quantityClass): array
    {
        $unitFiles = self::findUnitFiles($quantityClass);

        return self::buildAliasMap($unitFiles, $quantityClass);
    }

    /**
     * @param class-string<Quantity<UnitOfMeasure>> $quantityClass
     * @return list<string>
     * @throws UnitNotFound
     */
    private static function findUnitFiles(string $quantityClass): array
    {
        $quantityClassPath = substr($quantityClass, strlen('Monadial\\Siphon\\'));

        if ($quantityClassPath === '') {
            throw new UnitNotFound(
                sprintf('Unable to infer class path for quantity %s', $quantityClass),
            );
        }

        $unitDir = dirname(__DIR__) . '/' . str_replace('\\', '/', $quantityClassPath);
        $globResult = glob($unitDir . '/*.php');

        if ($globResult === false || $globResult === []) {
            throw new UnitNotFound(
                sprintf('No unit directory found for quantity %s', $quantityClass),
            );
        }

        return $globResult;
    }

    /**
     * @param list<string> $unitFiles
     * @param class-string<Quantity<UnitOfMeasure>> $quantityClass
     * @return array<string, class-string<UnitOfMeasure>>
     */
    private static function buildAliasMap(array $unitFiles, string $quantityClass): array
    {
        $map = [];

        /** @var list<class-string<UnitOfMeasure>> $unitClassList */
        $unitClassList = ArrayList::collect($unitFiles)
            ->map(static fn (string $file): string => $quantityClass . '\\' . pathinfo($file, PATHINFO_FILENAME))
            ->filter(static fn (string $class): bool => is_a($class, UnitOfMeasure::class, true))
            ->toList();

        foreach ($unitClassList as $unitClass) {
            self::registerUnitAliases($map, $unitClass);
        }

        return $map;
    }

    /**
     * @param array<string, class-string<UnitOfMeasure>> $map
     * @param class-string<UnitOfMeasure> $unitClass
     */
    private static function registerUnitAliases(array &$map, string $unitClass): void
    {
        $unit = $unitClass::make();

        foreach (AliasGenerator::generate($unit) as $alias) {
            $normalized = self::normalizeToken($alias);
            $map[$normalized] ??= $unitClass;
        }
    }
}
