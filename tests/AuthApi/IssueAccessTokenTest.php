<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\AuthApi;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\BadRequest;
use Studio15\Loymax\Authorization\Response\AccessTokenData;
use Studio15\Loymax\Authorization\Response\TwoFactorAuthenticationCodeRequired;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Получение токена доступа')]
final class IssueAccessTokenTest extends TestCase
{
    #[TestDox('Авторизация по паролю, успешный вход')]
    public function testSucceedAuthByPassword(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                    "token_type": "Bearer",
                    "access_token": "accessTokenValue",
                    "refresh_token": "refreshTokenValue",
                    "expires_in": 3600
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);

        /** @var AccessTokenData $result */
        $result = $loymax->authApi()->issueAccessToken(
            username: '79990001111',
            password: 'validPassword',
        );

        self::assertSame('Bearer', $result->tokenType);
        self::assertSame('accessTokenValue', $result->accessToken);
        self::assertSame('refreshTokenValue', $result->refreshToken);
        self::assertSame(3600, $result->expiresIn);
    }

    #[TestDox('Авторизация по паролю, некорректный пароль или пользователь не зарегистрирован')]
    public function testFailedAuthByPassword(): void
    {
        $this->expectException(BadRequest::class);
        $this->expectExceptionMessage('Неверное имя пользователя или пароль. Проверьте правильность введенных данных. Осталось 9 попыток.');

        $mockResponse = new Response(
            status: 400,
            body: <<<'JSON'
                {
                  "error": "IncorrectLoginOrPassword",
                  "error_description": "Неверное имя пользователя или пароль. Проверьте правильность введенных данных. Осталось 9 попыток."
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->authApi()->issueAccessToken(
            username: '79990001111',
            password: 'invalidPassword',
        );
    }

    #[TestDox('Двухфакторная авторизация, успешный запрос')]
    public function testSucceed2FARequest(): void
    {
        $mockResponse = new Response(
            status: 400,
            headers: [
                'X-Loymax-2FA' => '2FATokenValue',
            ],
            body: <<<'JSON'
                {
                  "error":"TwoFactorAuthenticationCodeRequired",
                  "error_description":"Введите код подтверждения, отправленный вам на телефон"
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);

        /** @var TwoFactorAuthenticationCodeRequired $result */
        $result = $loymax->authApi()->issueAccessToken(
            username: '79990001111',
        );

        self::assertSame('2FATokenValue', $result->twoFactorAuthToken);
    }

    #[TestDox('Двухфакторная авторизация, пользователь не зарегистрирован')]
    public function testUnregisteredUser(): void
    {
        $this->expectException(BadRequest::class);
        $this->expectExceptionMessage('Требуется указать пароль.');

        $mockResponse = new Response(
            status: 400,
            body: <<<'JSON'
                {
                  "error": "IncorrectLoginOrPassword",
                  "error_description": "Требуется указать пароль."
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->authApi()->issueAccessToken(
            username: 'unregisteredUsername',
        );
    }

    #[TestDox('Некорректный запрос')]
    public function testBadRequest(): void
    {
        $this->expectException(BadRequest::class);
        $this->expectExceptionMessage('Системная ошибка: f1b0ca7b122b48cd8799df04541115cd');

        $mockResponse = new Response(
            status: 400,
            body: <<<'JSON'
                {
                  "error": "Error",
                  "error_description": "Системная ошибка: f1b0ca7b122b48cd8799df04541115cd"
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->authApi()->issueAccessToken(
            username: 'incorrectUsername',
            password: 'incorrectPassword',
        );
    }
}
