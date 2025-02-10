<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\AuthApi;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\BadRequest;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Получение токена доступа по коду подтверждения')]
final class ConfirmTwoFactorAuthenticationTest extends TestCase
{
    #[TestDox('Двухфакторная авторизация, корректный токен и разовый код')]
    public function test2FASucceedConfirm(): void
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
        $result = $loymax->authApi()->confirmTwoFactorAuthentication(
            twoFactorAuthToken: 'valid2FATokenValue',
            code: '123456',
        );

        self::assertSame('Bearer', $result->tokenType);
        self::assertSame('accessTokenValue', $result->accessToken);
        self::assertSame('refreshTokenValue', $result->refreshToken);
        self::assertSame(3600, $result->expiresIn);
    }

    #[TestDox('Двухфакторная авторизация, некорректный токен')]
    public function test2FAInvalidToken(): void
    {
        $this->expectException(BadRequest::class);
        $this->expectExceptionMessage('Приложение не найдено');

        $mockResponse = new Response(
            status: 400,
            body: <<<'JSON'
                {
                  "error": "Приложение не найдено"
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->authApi()->confirmTwoFactorAuthentication(
            twoFactorAuthToken: 'invalid2FATokenValue',
            code: '123456',
        );
    }

    #[TestDox('Двухфакторная авторизация, некорректный разовый код')]
    public function test2FAInvalidCode(): void
    {
        $this->expectException(BadRequest::class);
        $this->expectExceptionMessage('Время ввода кода истекло Осталось 9 попыток.');

        $mockResponse = new Response(
            status: 400,
            body: <<<'JSON'
                {
                  "error": "AuthenticationWithConfirmCodeExpired",
                  "error_description": "Время ввода кода истекло Осталось 9 попыток."
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->authApi()->confirmTwoFactorAuthentication(
            twoFactorAuthToken: '2FATokenValue',
            code: '000000',
        );
    }
}
