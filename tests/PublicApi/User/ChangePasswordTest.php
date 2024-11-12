<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\User;

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
#[TestDox('Запрос на обновление пароля клиента')]
final class ChangePasswordTest extends TestCase
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
                JSON
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $result = $loymax->publicApi('validToken')
            ->user()
            ->changePassword(
                oldPassword: 'oldPassword',
                newPassword: 'newPassword',
            );

        self::assertSame('accessToken', $result->accessToken);
        self::assertSame('refreshToken', $result->refreshToken);
        self::assertSame('Bearer', $result->tokenType);
        self::assertSame(86400, $result->expiresIn);
    }

    #[TestDox('Неправильный пароль')]
    public function testInvalidOldPassword(): void
    {
        $this->expectException(InvalidResponse::class);
        $this->expectExceptionMessage('Неправильный пароль. Осталось 2 попытки.');

        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "result": {
                    "state": "Error",
                    "httpCode": 400,
                    "message": "Неправильный пароль. Осталось 2 попытки.",
                    "messageCode": "Business.Base",
                    "exception": null,
                    "validationErrors": null
                  }
                }
                JSON
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi('validToken')
            ->user()
            ->changePassword(
                oldPassword: 'invalidOldPassword',
                newPassword: 'newPassword',
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
        $loymax->publicApi('validToken')
            ->user()
            ->changePassword(
                oldPassword: 'oldPassword',
                newPassword: 'newPassword',
            );
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
                JSON
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi('invalidToken')
            ->user()
            ->changePassword(
                oldPassword: 'oldPassword',
                newPassword: 'newPassword',
            );
    }

    /**
     * @param array{
     *     oldPassword: non-empty-string,
     *     newPassword: non-empty-string
     * } $data
     */
    #[DataProvider('invalidChangePasswordRequestDataProvider')]
    #[TestDox('Невалидные данные в запросе')]
    public function testInvalidRequestData(array $data): void
    {
        $this->expectException(InvalidArgumentException::class);

        $loymax = $this->createLoymaxClient();

        $loymax->publicApi('validToken')
            ->user()
            ->changePassword(
                oldPassword: $data['oldPassword'],
                newPassword: $data['newPassword'],
            );
    }

    public static function invalidChangePasswordRequestDataProvider(): Iterator
    {
        yield 'пустой запрос' => [['oldPassword' => '', 'newPassword' => '']];

        yield 'пустой oldPassword' => [['oldPassword' => '', 'newPassword' => 'newPassword']];

        yield 'пустой newPassword' => [['oldPassword' => '123456', 'newPassword' => '']];

        yield 'новый пароль совпадает со старым' => [['oldPassword' => '123456', 'newPassword' => '123456']];
    }
}
