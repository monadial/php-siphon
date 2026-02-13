<?php

declare(strict_types=1);

namespace Monadial\Siphon\Tests\Exception;

use LogicException;
use Monadial\Siphon\Exception\InvalidArgument;
use Monadial\Siphon\Exception\ParseFailure;
use Monadial\Siphon\Exception\SiphonError;
use Monadial\Siphon\Exception\UnitNotFound;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SiphonError::class)]
#[CoversClass(InvalidArgument::class)]
#[CoversClass(ParseFailure::class)]
#[CoversClass(UnitNotFound::class)]
final class ExceptionTest extends TestCase
{
    public function testInvalidArgumentExtendsSiphonError(): void
    {
        $e = new InvalidArgument('bad arg');

        self::assertInstanceOf(SiphonError::class, $e);
        self::assertInstanceOf(LogicException::class, $e);
    }

    public function testInvalidArgumentCarriesMessage(): void
    {
        $e = new InvalidArgument('rate must be positive');

        self::assertSame('rate must be positive', $e->getMessage());
    }

    public function testInvalidArgumentCarriesCode(): void
    {
        $e = new InvalidArgument('msg', 42);

        self::assertSame(42, $e->getCode());
    }

    public function testParseFailureExtendsSiphonError(): void
    {
        $e = new ParseFailure('cannot parse');

        self::assertInstanceOf(SiphonError::class, $e);
        self::assertInstanceOf(LogicException::class, $e);
    }

    public function testParseFailureCarriesMessage(): void
    {
        $e = new ParseFailure('Unable to parse quantity from "abc"');

        self::assertSame('Unable to parse quantity from "abc"', $e->getMessage());
    }

    public function testUnitNotFoundExtendsSiphonError(): void
    {
        $e = new UnitNotFound('unknown unit');

        self::assertInstanceOf(SiphonError::class, $e);
        self::assertInstanceOf(LogicException::class, $e);
    }

    public function testUnitNotFoundCarriesMessage(): void
    {
        $e = new UnitNotFound('No unit directory found');

        self::assertSame('No unit directory found', $e->getMessage());
    }

    /** @throws InvalidArgument */
    public function testInvalidArgumentIsCatchableAsSiphonError(): void
    {
        $this->expectException(SiphonError::class);

        throw new InvalidArgument('test');
    }

    /** @throws ParseFailure */
    public function testParseFailureIsCatchableAsSiphonError(): void
    {
        $this->expectException(SiphonError::class);

        throw new ParseFailure('test');
    }

    /** @throws UnitNotFound */
    public function testUnitNotFoundIsCatchableAsSiphonError(): void
    {
        $this->expectException(SiphonError::class);

        throw new UnitNotFound('test');
    }
}
