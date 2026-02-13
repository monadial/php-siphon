<?php

declare(strict_types=1);

namespace Monadial\Siphon\Parsing;

use Fp\Collections\ArrayList;
use Monadial\Siphon\UnitOfMeasure;
use WeakMap;

/**
 * Generates all recognized string aliases for a unit from its name and symbol.
 *
 * Extracted from UnitOfMeasure — the unit itself is now a pure representation
 * and does not know how to produce parsing aliases.
 */
final class AliasGenerator
{
    private const array SI_PREFIXES = [
        'centi' => 'c',
        'deca' => 'da',
        'deci' => 'd',
        'exa' => 'E',
        'giga' => 'G',
        'hecto' => 'h',
        'kilo' => 'k',
        'mega' => 'M',
        'micro' => 'u',
        'milli' => 'm',
        'nano' => 'n',
        'peta' => 'P',
        'pico' => 'p',
        'tera' => 'T',
    ];

    private const array BASE_SYMBOLS = [
        'ampere' => 'A',
        'amperes' => 'A',
        'arcminute' => 'arcmin',
        'arcminutes' => 'arcmin',
        'arcsecond' => 'arcsec',
        'arcseconds' => 'arcsec',
        'bar' => 'bar',
        'bars' => 'bar',
        'bit' => 'b',
        'bits' => 'b',
        'btu' => 'Btu',
        'byte' => 'B',
        'bytes' => 'B',
        'calorie' => 'cal',
        'calories' => 'cal',
        'candela' => 'cd',
        'candelas' => 'cd',
        'celsius' => 'degC',
        'coulomb' => 'C',
        'coulombs' => 'C',
        'day' => 'd',
        'days' => 'd',
        'degree' => 'deg',
        'degrees' => 'deg',
        'dozen' => 'doz',
        'each' => 'ea',
        'electronvolt' => 'eV',
        'electronvolts' => 'eV',
        'fahrenheit' => 'degF',
        'farad' => 'F',
        'farads' => 'F',
        'feet' => 'ft',
        'foot' => 'ft',
        'gram' => 'g',
        'grams' => 'g',
        'gross' => 'gr',
        'henry' => 'H',
        'henrys' => 'H',
        'hertz' => 'Hz',
        'hour' => 'h',
        'hours' => 'h',
        'inch' => 'in',
        'inches' => 'in',
        'joule' => 'J',
        'joules' => 'J',
        'kelvin' => 'K',
        'kelvins' => 'K',
        'liter' => 'L',
        'liters' => 'L',
        'litre' => 'L',
        'litres' => 'L',
        'lumen' => 'lm',
        'lumens' => 'lm',
        'meter' => 'm',
        'meters' => 'm',
        'mile' => 'mi',
        'miles' => 'mi',
        'minute' => 'min',
        'minutes' => 'min',
        'mole' => 'mol',
        'moles' => 'mol',
        'month' => 'mo',
        'months' => 'mo',
        'nautical' => 'n',
        'newton' => 'N',
        'newtons' => 'N',
        'ohm' => 'Ohm',
        'ohms' => 'Ohm',
        'pascal' => 'Pa',
        'pascals' => 'Pa',
        'percent' => '%',
        'radian' => 'rad',
        'radians' => 'rad',
        'rankine' => 'degR',
        'score' => 'score',
        'second' => 's',
        'seconds' => 's',
        'siemens' => 'S',
        'tesla' => 'T',
        'teslas' => 'T',
        'turn' => 'turn',
        'turns' => 'turn',
        'volt' => 'V',
        'volts' => 'V',
        'watt' => 'W',
        'watts' => 'W',
        'weber' => 'Wb',
        'webers' => 'Wb',
        'week' => 'wk',
        'weeks' => 'wk',
        'yard' => 'yd',
        'yards' => 'yd',
        'year' => 'y',
        'years' => 'y',
    ];

    /**
     * @var WeakMap<UnitOfMeasure, list<string>>|null
     */
    private static ?WeakMap $cache = null;

    /**
     * Clear the alias cache (useful for testing).
     */
    public static function clearCache(): void
    {
        self::$cache = null;
    }

    /**
     * @return list<string>
     */
    public static function generate(UnitOfMeasure $unit): array
    {
        if (self::$cache === null) {
            /** @var WeakMap<UnitOfMeasure, list<string>> $cache */
            $cache = new WeakMap();
            self::$cache = $cache;
        }

        if (isset(self::$cache[$unit])) {
            return self::$cache[$unit];
        }

        $words = self::classWords($unit);
        $forms = ArrayList::collect($words)
            ->map(self::wordForms(...))
            ->toList();

        $aliases = [$unit->name(), $unit->symbol()];

        foreach (self::combineWordForms($forms) as $combo) {
            $aliases[] = implode(' ', $combo);
            $aliases[] = implode('', $combo);
        }

        /** @var list<string> $normalized */
        $normalized = array_values(array_unique(
            ArrayList::collect($aliases)
                ->map(self::normalizeAlias(...))
                ->toList(),
        ));

        self::$cache[$unit] = $normalized;

        return $normalized;
    }

    /**
     * @return list<string>
     */
    private static function classWords(UnitOfMeasure $unit): array
    {
        $shortName = substr($unit::class, (int) strrpos($unit::class, '\\') + 1);
        $spaced = preg_replace('/(?<!^)([A-Z])/', ' $1', $shortName) ?? $shortName;
        $rawParts = preg_split('/\s+/', strtolower($spaced)) ?: [];

        return ArrayList::collect($rawParts)
            ->flatMap(static fn (string $part): array => self::expandPart($part))
            ->filter(static fn (string $part): bool => $part !== '')
            ->toList();
    }

    /**
     * @return list<string>
     */
    private static function wordForms(string $word): array
    {
        if ($word === 'per') {
            return ['per', '/'];
        }

        $forms = [$word, self::singularOrPlural($word)];

        if ($word === 'micro') {
            $forms[] = 'µ';
        }

        $symbol = self::symbolToken($word);
        if ($symbol !== $word) {
            $forms[] = $symbol;
        }

        return array_values(array_unique($forms));
    }

    private static function singularOrPlural(string $word): string
    {
        if (str_ends_with($word, 's') && strlen($word) > 1) {
            return substr($word, 0, -1);
        }

        return $word . 's';
    }

    /**
     * Cartesian product of word-form alternatives.
     *
     * @param list<list<string>> $forms
     * @return list<list<string>>
     */
    private static function combineWordForms(array $forms): array
    {
        return array_reduce(
            $forms,
            static fn (array $result, array $group): array => self::appendGroup($result, $group),
            [[]],
        );
    }

    /**
     * @param list<list<string>> $result
     * @param list<string> $group
     * @return list<list<string>>
     */
    private static function appendGroup(array $result, array $group): array
    {
        $next = [];
        foreach ($result as $prefix) {
            foreach ($group as $item) {
                $next[] = [...$prefix, $item];
            }
        }

        return $next;
    }

    private static function normalizeAlias(string $alias): string
    {
        $normalized = strtolower(trim(str_replace('µ', 'u', $alias)));
        $normalized = preg_replace('/\s*\/\s*/', '/', $normalized) ?? $normalized;

        return preg_replace('/\s+/', ' ', $normalized) ?? $normalized;
    }

    private static function symbolToken(string $word): string
    {
        return self::BASE_SYMBOLS[$word]
            ?? self::SI_PREFIXES[$word]
            ?? self::prefixedSymbolToken($word);
    }

    private static function prefixedSymbolToken(string $word): string
    {
        foreach (self::SI_PREFIXES as $prefix => $prefixSymbol) {
            $match = self::matchPrefixedBase($word, $prefix, $prefixSymbol);
            if ($match !== null) {
                return $match;
            }
        }

        return $word;
    }

    private static function matchPrefixedBase(string $word, string $prefix, string $prefixSymbol): ?string
    {
        if (!str_starts_with($word, $prefix)) {
            return null;
        }

        $rest = substr($word, strlen($prefix));

        return $rest !== '' && isset(self::BASE_SYMBOLS[$rest])
            ? $prefixSymbol . self::BASE_SYMBOLS[$rest]
            : null;
    }

    /**
     * @return list<string>
     */
    private static function expandPart(string $part): array
    {
        if ($part === '' || $part === 'of') {
            return [];
        }

        return self::trySplitPrefix($part) ?? [$part];
    }

    /**
     * @return list<string>|null
     */
    private static function trySplitPrefix(string $part): ?array
    {
        foreach (array_keys(self::SI_PREFIXES) as $prefix) {
            if (!str_starts_with($part, $prefix)) {
                continue;
            }

            $rest = substr($part, strlen($prefix));
            if ($rest !== '') {
                return [$prefix, $rest];
            }
        }

        return null;
    }
}
