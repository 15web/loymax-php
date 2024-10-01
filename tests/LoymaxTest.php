<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Studio15\Loymax\ApiClient\GuzzleHttpClientFactory;
use Studio15\Loymax\Loymax;

/**
 * @internal
 */
#[TestDox('Loymax API')]
final class LoymaxTest extends TestCase
{
    #[TestDox('Статический конструктор')]
    public function testCreate(): void
    {
        $this->expectNotToPerformAssertions();

        Loymax::create('https://loymax.tech');
    }

    #[TestDox('Пустая строка в baseUri')]
    public function testEmptyBaseUri(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Loymax::create('');
    }

    #[TestDox('Пустой конструктор')]
    public function testEmptyConstructor(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Loymax();
    }

    #[TestDox('baseUri null в конструкторе')]
    public function testNullBaseUri(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Loymax(baseUri: null);
    }

    #[TestDox('Http-клиент в конструкторе не требует baseUri')]
    public function testBaseUriAndHttpClient(): void
    {
        $this->expectNotToPerformAssertions();

        new Loymax(httpClient: GuzzleHttpClientFactory::create('https://loymax.tech'));
    }

    #[TestDox('Логгер передан в конструктор')]
    public function testLogger(): void
    {
        $this->expectNotToPerformAssertions();

        new Loymax(
            baseUri: 'https://loymax.tech',
            logger: new NullLogger(),
        );
    }
}
