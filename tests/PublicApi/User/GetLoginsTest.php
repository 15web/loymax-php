<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\User;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Получение списка логинов пользователя')]
final class GetLoginsTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSucceed(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "identifiers": [
                      {
                        "identifierType": "Login",
                        "value": "9c00590c-c106-4054-afb5-24ef395dd822"
                      },
                      {
                        "identifierType": "Login",
                        "value": "7077901100136482"
                      },
                      {
                        "identifierType": "Login",
                        "value": "79538051369"
                      },
                      {
                        "identifierType": "Login",
                        "value": "example@example.ru"
                      }
                    ]
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
        $identifiers = $loymax->publicApi('validAccessToken')->user()->getLogins()->identifiers;

        self::assertCount(4, $identifiers);

        self::assertSame('Login', $identifiers[0]->identifierType);
        self::assertSame('9c00590c-c106-4054-afb5-24ef395dd822', $identifiers[0]->value);

        self::assertSame('Login', $identifiers[1]->identifierType);
        self::assertSame('7077901100136482', $identifiers[1]->value);

        self::assertSame('Login', $identifiers[2]->identifierType);
        self::assertSame('79538051369', $identifiers[2]->value);

        self::assertSame('Login', $identifiers[3]->identifierType);
        self::assertSame('example@example.ru', $identifiers[3]->value);
    }

    #[TestDox('Пустой список')]
    public function testEmptyList(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "identifiers": []
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
        $identifiers = $loymax->publicApi('validAccessToken')->user()->getLogins()->identifiers;

        self::assertEmpty($identifiers);
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
        $loymax->publicApi()->user()->getLogins();
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
        $loymax->publicApi('validAccessToken')->user()->getLogins();
    }
}
