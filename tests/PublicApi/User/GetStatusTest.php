<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\User;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\PublicApi\User\Response\StatusItem;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Получение информации о статусах в статусных системах')]
final class GetStatusTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSucceed(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": [
                    {
                      "name": "Статусная система 1",
                      "logicalName": "StatusSystem",
                      "description": "Статус считается за 6 месяцев с момента первой покупки",
                      "statuses": [
                        {
                          "name": "Дегустатор",
                          "threshold": 99.0,
                          "description": "Начисление бонусов 2% от суммы чека",
                          "descriptionLong": null,
                          "preferences": "2%",
                          "preferencesAdditional": null
                        },
                        {
                          "name": "Любитель",
                          "threshold": 199.0,
                          "description": "Начисление бонусов 3% от суммы чека",
                          "descriptionLong": null,
                          "preferences": "3%",
                          "preferencesAdditional": null
                        }
                      ],
                      "currentStatus": {
                        "name": "Дегустатор",
                        "threshold": 99.0,
                        "description": "Начисление бонусов 2% от суммы чека",
                        "descriptionLong": null,
                        "preferences": "2%",
                        "preferencesAdditional": null
                      },
                      "counterUid": "3e756421-cea8-4f71-90fe-c98a1b013151",
                      "currentValue": 0.0,
                      "nextStatusValue": 100.0,
                      "fileExternalId": "241ef23e-ac0e-368b-0206-97e62c46f65a",
                      "statusUpdateDate": null,
                      "statusUpdatePeriod": null
                    }
                  ],
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
        $result = $loymax->publicApi('validAccessToken')->user()->getStatus();

        self::assertCount(1, $result);
        self::assertSame('Статусная система 1', $result[0]->name);
        self::assertSame('StatusSystem', $result[0]->logicalName);
        self::assertSame('Статус считается за 6 месяцев с момента первой покупки', $result[0]->description);

        self::assertCount(2, $result[0]->statuses);

        self::assertSame('Дегустатор', $result[0]->statuses[0]->name);
        self::assertSame(99.0, $result[0]->statuses[0]->threshold);
        self::assertSame('Начисление бонусов 2% от суммы чека', $result[0]->statuses[0]->description);
        self::assertSame('2%', $result[0]->statuses[0]->preferences);
        self::assertNull($result[0]->statuses[0]->preferencesAdditional);

        self::assertSame('Любитель', $result[0]->statuses[1]->name);
        self::assertSame(199.0, $result[0]->statuses[1]->threshold);
        self::assertSame('Начисление бонусов 3% от суммы чека', $result[0]->statuses[1]->description);
        self::assertSame('3%', $result[0]->statuses[1]->preferences);
        self::assertNull($result[0]->statuses[1]->preferencesAdditional);

        /** @var StatusItem $currentStatus */
        $currentStatus = $result[0]->currentStatus;

        self::assertSame('Дегустатор', $currentStatus->name);
        self::assertSame(99.0, $currentStatus->threshold);
        self::assertSame('Начисление бонусов 2% от суммы чека', $currentStatus->description);
        self::assertSame('2%', $currentStatus->preferences);
        self::assertNull($currentStatus->preferencesAdditional);

        self::assertSame(0.0, $result[0]->currentValue);
        self::assertSame(100.0, $result[0]->nextStatusValue);
    }

    #[TestDox('Текущий статус не определен')]
    public function testCurrentStatusNull(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": [
                    {
                      "name": "Статусная система 1",
                      "logicalName": "StatusSystem",
                      "description": "Статус считается за 6 месяцев с момента первой покупки",
                      "statuses": [
                        {
                          "name": "Дегустатор",
                          "threshold": 99.0,
                          "description": "Начисление бонусов 2% от суммы чека",
                          "descriptionLong": null,
                          "preferences": "2%",
                          "preferencesAdditional": null
                        },
                        {
                          "name": "Любитель",
                          "threshold": 199.0,
                          "description": "Начисление бонусов 3% от суммы чека",
                          "descriptionLong": null,
                          "preferences": "3%",
                          "preferencesAdditional": null
                        }
                      ],
                      "currentStatus": null,
                      "counterUid": "3e756421-cea8-4f71-90fe-c98a1b013151",
                      "currentValue": 0.0,
                      "nextStatusValue": 100.0,
                      "fileExternalId": "241ef23e-ac0e-368b-0206-97e62c46f65a",
                      "statusUpdateDate": null,
                      "statusUpdatePeriod": null
                    }
                  ],
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
        $result = $loymax->publicApi('validAccessToken')->user()->getStatus();

        self::assertCount(1, $result);
        self::assertSame('Статусная система 1', $result[0]->name);
        self::assertSame('StatusSystem', $result[0]->logicalName);
        self::assertSame('Статус считается за 6 месяцев с момента первой покупки', $result[0]->description);

        self::assertCount(2, $result[0]->statuses);

        self::assertSame('Дегустатор', $result[0]->statuses[0]->name);
        self::assertSame(99.0, $result[0]->statuses[0]->threshold);
        self::assertSame('Начисление бонусов 2% от суммы чека', $result[0]->statuses[0]->description);
        self::assertSame('2%', $result[0]->statuses[0]->preferences);
        self::assertNull($result[0]->statuses[0]->preferencesAdditional);

        self::assertSame('Любитель', $result[0]->statuses[1]->name);
        self::assertSame(199.0, $result[0]->statuses[1]->threshold);
        self::assertSame('Начисление бонусов 3% от суммы чека', $result[0]->statuses[1]->description);
        self::assertSame('3%', $result[0]->statuses[1]->preferences);
        self::assertNull($result[0]->statuses[1]->preferencesAdditional);

        self::assertNull($result[0]->currentStatus);

        self::assertSame(0.0, $result[0]->currentValue);
        self::assertSame(100.0, $result[0]->nextStatusValue);
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
        $loymax->publicApi()->user()->getStatus();
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
        $loymax->publicApi('validAccessToken')->user()->getStatus();
    }
}
