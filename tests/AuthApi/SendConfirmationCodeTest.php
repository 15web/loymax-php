<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\AuthApi;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Повторная отправка кода подтверждения')]
final class SendConfirmationCodeTest extends TestCase
{
    #[TestDox('Успешный запрос')]
    public function testSucceedRequest(): void
    {
        $this->expectNotToPerformAssertions();

        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "result": {
                    "state": "Success",
                    "httpCode": 200,
                    "message": "Код подтверждения отправлен",
                    "messageCode": null,
                    "exception": null,
                    "validationErrors": null
                  }
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);

        $loymax->authApi()->sendConfirmationCode(
            twoFactorAuthToken: 'validTwoFactorAuthToken',
        );
    }

    #[TestDox('Некорректный токен')]
    public function testInvalidToken(): void
    {
        $this->expectNotToPerformAssertions();

        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "result": {
                    "state": "Success",
                    "httpCode": 200,
                    "message": "Код подтверждения отправлен",
                    "messageCode": null,
                    "exception": null,
                    "validationErrors": null
                  }
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);

        $loymax->authApi()->sendConfirmationCode(
            twoFactorAuthToken: 'invalidTwoFactorAuthToken',
        );
    }

    #[TestDox('Превышен лимит на количество запросов кода подтверждения')]
    public function testLimitExceed(): void
    {
        $this->expectException(InvalidResponse::class);
        $this->expectExceptionMessage('Отправка кода подтверждения заблокирована. Разблокировка произойдет через 30 минут.');

        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "result": {
                    "state": "Error",
                    "message": "Отправка кода подтверждения заблокирована. Разблокировка произойдет через 30 минут.",
                    "messageCode": null,
                    "exception": null,
                    "validationErrors": null
                  }
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->authApi()->sendConfirmationCode(
            twoFactorAuthToken: 'validTwoFactorAuthToken',
        );
    }
}
