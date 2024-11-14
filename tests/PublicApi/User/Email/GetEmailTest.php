<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\User\Email;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Получение текущего статуса email клиента')]
final class GetEmailTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSucceed(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "currentEmail": null,
                    "newEmail": null,
                    "confirmCodeLength": 0,
                    "currentNotifierStatus": "Unverified",
                    "notifierMask": null
                  },
                  "result": {
                    "state": "Success",
                    "httpCode": 200,
                    "message": null,
                    "messageCode": null,
                    "exception": null,
                    "validationErrors": null
                  }
                }
                JSON
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $result = $loymax->publicApi('validAccessToken')->user()->getEmail();

        self::assertNull($result->currentEmail);
        self::assertNull($result->newEmail->email);
        self::assertSame(0, $result->confirmCodeLength);
        self::assertSame('Unverified', $result->currentNotifierStatus->value);
        self::assertNull($result->notifierMask);
    }

    #[TestDox('Успешный результат, начата смена email')]
    public function testSucceedChangingEmail(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "currentEmail": "old@example.com",
                    "newEmail": {
                      "email": "new@example.com"
                    },
                    "confirmCodeLength": 6,
                    "currentNotifierStatus": "Unverified",
                    "notifierMask": null
                  },
                  "result": {
                    "state": "Success",
                    "httpCode": 200,
                    "message": null,
                    "messageCode": null,
                    "exception": null,
                    "validationErrors": null
                  }
                }
                JSON
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $result = $loymax->publicApi('validAccessToken')->user()->getEmail();

        self::assertSame('old@example.com', $result->currentEmail);
        self::assertSame('new@example.com', $result->newEmail->email);
        self::assertSame(6, $result->confirmCodeLength);
        self::assertSame('Unverified', $result->currentNotifierStatus->value);
        self::assertNull($result->notifierMask);
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
        $loymax->publicApi()->user()->getEmail();
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
        $loymax->publicApi('validAccessToken')->user()->getEmail();
    }
}
