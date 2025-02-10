<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\User\Phone;

use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\Test\TestCase;

/** @internal */
#[TestDox('Подтверждение номера телефона')]
final class ConfirmPhoneNumberTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSucceed(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "token_type": "Bearer",
                    "access_token": "accessToken",
                    "refresh_token": "refreshToken",
                    "expires_in": 86400
                  },
                  "result": {
                    "state": "Success",
                    "message": null,
                    "messageCode": null,
                    "exception": null,
                    "validationErrors": null
                  }
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $result = $loymax->publicApi('validAccessToken')
            ->user()
            ->confirmPhoneNumber(
                confirmCode: 'code',
                password: 'password',
            );

        self::assertSame('accessToken', $result->accessToken);
        self::assertSame('refreshToken', $result->refreshToken);
        self::assertSame('Bearer', $result->tokenType);
        self::assertSame(86400, $result->expiresIn);
    }

    #[TestDox('Неавторизованный запрос')]
    public function testUnauthorized(): void
    {
        $this->expectException(Unauthorized::class);

        $mockResponse = new Response(
            status: 401,
            body: <<<'JSON'
                {
                  "message": "Запрещён анонимный доступ к методу."
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi()
            ->user()
            ->confirmPhoneNumber(
                confirmCode: 'code',
                password: 'password',
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
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi('validAccessToken')
            ->user()
            ->confirmPhoneNumber(
                confirmCode: 'code',
                password: 'password',
            );
    }

    /**
     * @param non-empty-string $confirmCode
     * @param non-empty-string $password
     */
    #[TestDox('Невалидные данные в запросе')]
    #[DataProvider('invalidConfirmPhoneNumberRequestDataProvider')]
    public function testInvalidRequestData(string $confirmCode, string $password): void
    {
        $this->expectException(InvalidArgumentException::class);

        $loymax = $this->createLoymaxClient();
        $loymax->publicApi('validAccessToken')
            ->user()
            ->confirmPhoneNumber(
                confirmCode: $confirmCode,
                password: $password,
            );
    }

    public static function invalidConfirmPhoneNumberRequestDataProvider(): Iterator
    {
        yield 'пустой confirmCode' => ['', 'password'];

        yield 'пустой password' => ['confirmCode', ''];
    }
}
