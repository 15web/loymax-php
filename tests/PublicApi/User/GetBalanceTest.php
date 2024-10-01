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
#[TestDox('Возвращает информацию о балансе клиента')]
final class GetBalanceTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSucceed(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": [
                    {
                      "currency": {
                        "id": 1,
                        "name": "Default",
                        "code": "RUB",
                        "uid": "018e754e-d7e7-7a37-92bc-f6aebbe1d1af",
                        "externalId": "2",
                        "imageId": "018e754f-23ea-74e7-b65d-ddf17ef21b37",
                        "description": "Default account",
                        "isDeleted": false,
                        "nameCases": {
                          "nominative": "Default",
                          "genitive": "Default",
                          "plural": "Default",
                          "abbreviation": "Default"
                        }
                      },
                      "balance": 10.500,
                      "notActivated": 20.000,
                      "accumulated": 60.500,
                      "paid": 30.0
                    }
                  ],
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
        $result = $loymax->publicApi('validAccessToken')->user()->getBalance();

        self::assertSame(1, $result[0]->currency->id);
        self::assertSame('Default', $result[0]->currency->name);
        self::assertSame('RUB', $result[0]->currency->code);
        self::assertEqualsWithDelta(10.500, $result[0]->balance, PHP_FLOAT_EPSILON);
        self::assertEqualsWithDelta(20.000, $result[0]->notActivated, PHP_FLOAT_EPSILON);
        self::assertEqualsWithDelta(60.500, $result[0]->accumulated, PHP_FLOAT_EPSILON);
        self::assertEqualsWithDelta(30.0, $result[0]->paid, PHP_FLOAT_EPSILON);
    }

    #[TestDox('Неавторизованный запрос')]
    public function testUnauthorized(): void
    {
        $this->expectException(Unauthorized::class);

        $mockResponse = new Response(
            status: 401,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi()->user()->getBalance();
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
        $loymax->publicApi('validAccessToken')->user()->getBalance();
    }
}
