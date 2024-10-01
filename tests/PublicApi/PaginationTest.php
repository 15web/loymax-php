<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Studio15\Loymax\PublicApi\Data\Pagination;
use Webmozart\Assert\InvalidArgumentException;

/**
 * @internal
 */
#[TestDox('Пагинация')]
final class PaginationTest extends TestCase
{
    #[TestDox('Корректные значения')]
    public function testValidArguments(): void
    {
        $pagination = new Pagination(
            from: 0,
            count: 10,
        );

        self::assertSame(0, $pagination->from);
        self::assertSame(10, $pagination->count);
    }

    #[TestDox('Некорректное значение from')]
    public function testInvalidFrom(): void
    {
        $this->expectException(InvalidArgumentException::class);

        /** @psalm-suppress InvalidArgument */
        new Pagination(
            from: -10, // @phpstan-ignore argument.type
            count: 10,
        );
    }

    #[TestDox('Некорректное значение count')]
    public function testInvalidCount(): void
    {
        $this->expectException(InvalidArgumentException::class);

        /** @psalm-suppress InvalidArgument */
        new Pagination(
            from: 0,
            count: 0, // @phpstan-ignore argument.type
        );
    }
}
