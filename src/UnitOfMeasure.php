<?php

declare(strict_types=1);

namespace Monadial\Siphon;

use Brick\Math\BigDecimal;
use LogicException;

/**
 * @psalm-consistent-constructor
 * @template T of Quantity
 */
abstract readonly class UnitOfMeasure
{
    /**
     * @psalm-pure
     * @return static
     */
    public static function make(): static
    {
        /** @psalm-suppress UnsafeGenericInstantiation */
        return new static();
    }

    /**
     * @psalm-api
     * @param BigDecimal|int|float|string $value
     * @return T
     */
    public static function from(BigDecimal|int|float|string $value): Quantity
    {
        $quantityClass = substr(static::class, 0, (int) strrpos(static::class, '\\'));

        if (!is_string($quantityClass) || $quantityClass === '' || !is_a($quantityClass, Quantity::class, true)) {
            throw new LogicException(sprintf('Unable to infer quantity class for unit %s', static::class));
        }

        /** @var T */
        return new $quantityClass(BigDecimal::of($value), static::make());
    }

    abstract public function factor(): BigDecimal;

    public function offset(): BigDecimal
    {
        return BigDecimal::zero();
    }

    public function name(): string
    {
        $class = static::class;
        $shortName = substr($class, (int) strrpos($class, '\\') + 1);
        $spaced = preg_replace('/(?<!^)([A-Z])/', ' $1', $shortName) ?? $shortName;

        return strtolower($spaced);
    }

    public function symbol(): string
    {
        $parts = [];
        $power = null;

        foreach (self::classWords() as $word) {
            if ($word === 'square') {
                $power = 2;
                continue;
            }

            if ($word === 'cubic') {
                $power = 3;
                continue;
            }

            if ($word === 'per') {
                $parts[] = '/';
                continue;
            }

            $segment = self::symbolToken($word);

            if ($power !== null) {
                $segment .= (string) $power;
                $power = null;
            }

            $parts[] = $segment;
        }

        $symbol = implode('', $parts);

        return $symbol !== '' ? $symbol : $this->name();
    }

    /**
     * @return list<string>
     */
    public function aliases(): array
    {
        /** @var array<string, list<string>> $cache */
        static $cache = [];

        if (array_key_exists(static::class, $cache)) {
            return $cache[static::class];
        }

        $forms = array_map(self::wordForms(...), self::classWords());

        $aliases = [];
        $aliases[] = $this->name();
        $aliases[] = $this->symbol();

        foreach (self::combineWordForms($forms) as $combo) {
            $aliases[] = implode(' ', $combo);
            $aliases[] = implode('', $combo);
        }

        /** @var list<string> $normalized */
        $normalized = array_values(array_unique(array_map(self::normalizeAlias(...), $aliases)));
        $cache[static::class] = $normalized;

        return $normalized;
    }

    /**
     * @psalm-pure
     */
    // phpcs:ignore SlevomatCodingStandard.Classes.RequireSelfReference.RequiredSelfReference
    public function equals(self $that): bool
    {
        // phpcs:ignore SlevomatCodingStandard.Classes.RequireSelfReference.RequiredSelfReference
        return $that::class === static::class;
    }

    /**
     * @return list<string>
     */
    private static function classWords(): array
    {
        $class = static::class;
        $shortName = substr($class, (int) strrpos($class, '\\') + 1);
        $spaced = preg_replace('/(?<!^)([A-Z])/', ' $1', $shortName) ?? $shortName;
        $rawParts = preg_split('/\s+/', strtolower($spaced)) ?: [];

        $parts = [];
        foreach ($rawParts as $part) {
            foreach (self::expandPart($part) as $expanded) {
                $parts[] = $expanded;
            }
        }

        return array_values(array_filter($parts, static fn (string $part): bool => $part !== ''));
    }

    /**
     * @return list<string>
     */
    private static function wordForms(string $word): array
    {
        if ($word === 'per') {
            return ['per', '/'];
        }

        $forms = [$word];

        if (str_ends_with($word, 's') && strlen($word) > 1) {
            $forms[] = substr($word, 0, -1);
        } elseif (!str_ends_with($word, 's')) {
            $forms[] = $word . 's';
        }

        if ($word === 'micro') {
            $forms[] = 'µ';
        }

        $symbol = self::symbolToken($word);
        if ($symbol !== $word) {
            $forms[] = $symbol;
        }

        return array_values(array_unique($forms));
    }

    /**
     * @param list<list<string>> $forms
     * @return list<list<string>>
     */
    private static function combineWordForms(array $forms): array
    {
        $result = [[]];

        foreach ($forms as $group) {
            $next = [];
            foreach ($result as $prefix) {
                foreach ($group as $item) {
                    $candidate = $prefix;
                    $candidate[] = $item;
                    $next[] = $candidate;
                }
            }
            $result = $next;
        }

        return $result;
    }

    private static function normalizeAlias(string $alias): string
    {
        $normalized = strtolower(trim(str_replace('µ', 'u', $alias)));
        $normalized = preg_replace('/\s*\/\s*/', '/', $normalized) ?? $normalized;
        $normalized = preg_replace('/\s+/', ' ', $normalized) ?? $normalized;

        return $normalized;
    }

    private static function symbolToken(string $word): string
    {
        $prefixes = [
            'deca' => 'da',
            'hecto' => 'h',
            'kilo' => 'k',
            'mega' => 'M',
            'giga' => 'G',
            'tera' => 'T',
            'peta' => 'P',
            'exa' => 'E',
            'deci' => 'd',
            'centi' => 'c',
            'milli' => 'm',
            'micro' => 'u',
            'nano' => 'n',
            'pico' => 'p',
        ];

        $base = [
            'meter' => 'm',
            'meters' => 'm',
            'gram' => 'g',
            'grams' => 'g',
            'litre' => 'L',
            'litres' => 'L',
            'liter' => 'L',
            'liters' => 'L',
            'second' => 's',
            'seconds' => 's',
            'minute' => 'min',
            'minutes' => 'min',
            'hour' => 'h',
            'hours' => 'h',
            'day' => 'd',
            'days' => 'd',
            'week' => 'wk',
            'weeks' => 'wk',
            'month' => 'mo',
            'months' => 'mo',
            'year' => 'y',
            'years' => 'y',
            'inch' => 'in',
            'inches' => 'in',
            'foot' => 'ft',
            'feet' => 'ft',
            'yard' => 'yd',
            'yards' => 'yd',
            'mile' => 'mi',
            'miles' => 'mi',
            'nautical' => 'n',
            'watt' => 'W',
            'watts' => 'W',
            'joule' => 'J',
            'joules' => 'J',
            'volt' => 'V',
            'volts' => 'V',
            'ampere' => 'A',
            'amperes' => 'A',
            'ohm' => 'Ohm',
            'ohms' => 'Ohm',
            'pascal' => 'Pa',
            'pascals' => 'Pa',
            'bar' => 'bar',
            'bars' => 'bar',
            'newton' => 'N',
            'newtons' => 'N',
            'hertz' => 'Hz',
            'siemens' => 'S',
            'henry' => 'H',
            'henrys' => 'H',
            'farad' => 'F',
            'farads' => 'F',
            'coulomb' => 'C',
            'coulombs' => 'C',
            'tesla' => 'T',
            'teslas' => 'T',
            'weber' => 'Wb',
            'webers' => 'Wb',
            'candela' => 'cd',
            'candelas' => 'cd',
            'lumen' => 'lm',
            'lumens' => 'lm',
            'mole' => 'mol',
            'moles' => 'mol',
            'byte' => 'B',
            'bytes' => 'B',
            'bit' => 'b',
            'bits' => 'b',
            'calorie' => 'cal',
            'calories' => 'cal',
            'btu' => 'Btu',
            'electronvolt' => 'eV',
            'electronvolts' => 'eV',
            'kelvin' => 'K',
            'kelvins' => 'K',
            'celsius' => 'degC',
            'fahrenheit' => 'degF',
            'rankine' => 'degR',
            'degree' => 'deg',
            'degrees' => 'deg',
            'radian' => 'rad',
            'radians' => 'rad',
            'turn' => 'turn',
            'turns' => 'turn',
            'arcminute' => 'arcmin',
            'arcminutes' => 'arcmin',
            'arcsecond' => 'arcsec',
            'arcseconds' => 'arcsec',
            'percent' => '%',
            'dozen' => 'doz',
            'score' => 'score',
            'gross' => 'gr',
            'each' => 'ea',
        ];

        if (array_key_exists($word, $base)) {
            return $base[$word];
        }

        if (array_key_exists($word, $prefixes)) {
            return $prefixes[$word];
        }

        foreach ($prefixes as $prefix => $prefixSymbol) {
            if (str_starts_with($word, $prefix)) {
                $rest = substr($word, strlen($prefix));
                if ($rest !== '' && array_key_exists($rest, $base)) {
                    return $prefixSymbol . $base[$rest];
                }
            }
        }

        return $word;
    }

    /**
     * @return list<string>
     */
    private static function expandPart(string $part): array
    {
        if ($part === '' || $part === 'of') {
            return [];
        }

        foreach (['deca', 'hecto', 'kilo', 'mega', 'giga', 'tera', 'peta', 'exa', 'deci', 'centi', 'milli', 'micro', 'nano', 'pico'] as $prefix) {
            if (str_starts_with($part, $prefix) && strlen($part) > strlen($prefix)) {
                $rest = substr($part, strlen($prefix));
                if ($rest !== '') {
                    return [$prefix, $rest];
                }
            }
        }

        return [$part];
    }
}
