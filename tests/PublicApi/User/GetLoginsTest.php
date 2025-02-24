<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\User;

use DateTimeInterface;
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
                    ],
                    "socialIdentifiers": [
                      {
                        "provider": "VKontakte",
                        "userId": "123456789",
                        "creationDate": "2018-06-08T06:54:33.780Z"
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
        $result = $loymax->publicApi('validAccessToken')->user()->getLogins();

        self::assertCount(4, $result->identifiers);

        self::assertSame('Login', $result->identifiers[0]->identifierType);
        self::assertSame('9c00590c-c106-4054-afb5-24ef395dd822', $result->identifiers[0]->value);

        self::assertSame('Login', $result->identifiers[1]->identifierType);
        self::assertSame('7077901100136482', $result->identifiers[1]->value);

        self::assertSame('Login', $result->identifiers[2]->identifierType);
        self::assertSame('79538051369', $result->identifiers[2]->value);

        self::assertSame('Login', $result->identifiers[3]->identifierType);
        self::assertSame('example@example.ru', $result->identifiers[3]->value);

        self::assertCount(1, $result->socialIdentifiers);

        self::assertSame('VKontakte', $result->socialIdentifiers[0]->provider);
        self::assertSame('123456789', $result->socialIdentifiers[0]->userId);
        self::assertSame('2018-06-08T06:54:33+00:00', $result->socialIdentifiers[0]->creationDate->format(DateTimeInterface::ATOM));
    }

    #[TestDox('Пустой список')]
    public function testEmptyList(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "identifiers": [],
                    "socialIdentifiers": []
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
