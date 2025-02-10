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
#[TestDox('Перевыпуск токена доступа по токену обновления')]
final class RefreshAccessTokenTest extends TestCase
{
    #[TestDox('Получение токена доступа (срок жизни refresh token не прошел)')]
    public function testSucceedRequest(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                    "token_type": "Bearer",
                    "access_token": "newAccessTokenValue",
                    "refresh_token": "newRefreshTokenValue",
                    "expires_in": 3600
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);

        $result = $loymax->authApi()->refreshAccessToken(
            accessToken: 'expiredAccessTokenValue',
            refreshToken: 'refreshTokenValue',
        );

        self::assertSame('Bearer', $result->tokenType);
        self::assertSame('newAccessTokenValue', $result->accessToken);
        self::assertSame('newRefreshTokenValue', $result->refreshToken);
        self::assertSame(3600, $result->expiresIn);
    }

    #[TestDox('Получение токена доступа (срок жизни refresh token прошел)')]
    public function testFailedRequest(): void
    {
        $this->expectException(BadRequest::class);
        $this->expectExceptionMessage('invalid_grant');

        $mockResponse = new Response(
            status: 400,
            body: <<<'JSON'
                {
                    "error":"invalid_grant"
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->authApi()->refreshAccessToken(
            accessToken: 'expiredAccessTokenValue',
            refreshToken: 'expiredRefreshTokenValue',
        );
    }
}
