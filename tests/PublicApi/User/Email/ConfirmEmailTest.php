<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\User\Email;

use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Подтверждение нового email')]
final class ConfirmEmailTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSucceed(): void
    {
        self::expectNotToPerformAssertions();

        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "result": {
                    "state": "Success",
                    "message": null,
                    "messageCode": null,
                    "exception": null,
                    "validationErrors": null
                  }
                }
                JSON
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi('validAccessToken')
            ->user()
            ->confirmEmail(
                confirmCode: 'code',
                password: 'password'
            );
    }

    #[TestDox('Неавторизованный запрос')]
    public function testUnauthorized(): void
    {
        $this->expectException(Unauthorized::class);

        $mockResponse = new Response(
            status: 401,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi()
            ->user()
            ->confirmEmail(
                confirmCode: 'code',
                password: 'password'
            );
    }

    #[TestDox('Запрос завершился с ошибкой')]
    public function testFailed(): void
    {
        $this->expectException(InvalidResponse::class);
        $this->expectExceptionMessage('Request failed');

        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "result": {
                    "state": "Error",
                    "message": "Request failed",
                    "messageCode": "invalid.request",
                    "exception": "InvalidRequest",
                    "validationErrors": []
                  }
                }
                JSON
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi('validAccessToken')
            ->user()
            ->confirmEmail(
                confirmCode: 'code',
                password: 'password'
            );
    }

    /**
     * @param non-empty-string $confirmCode
     * @param non-empty-string $password
     */
    #[TestDox('Невалидные данные в запросе')]
    #[DataProvider('invalidConfirmEmailRequestDataProvider')]
    public function testInvalidRequestData(string $confirmCode, string $password): void
    {
        $this->expectException(InvalidArgumentException::class);

        $loymax = $this->createLoymaxClient();
        $loymax->publicApi('validAccessToken')
            ->user()
            ->confirmEmail(
                confirmCode: $confirmCode,
                password: $password
            );
    }

    public static function invalidConfirmEmailRequestDataProvider(): Iterator
    {
        yield 'пустой confirmCode' => ['', 'password'];

        yield 'пустой password' => ['confirmCode', ''];
    }
}
