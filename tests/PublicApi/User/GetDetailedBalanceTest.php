<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\User;

use DateTimeImmutable;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\PublicApi\User\Response\Period;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Получение детализированного баланса')]
final class GetDetailedBalanceTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSucceed(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "items": [
                      {
                        "currency": {
                          "id": 1,
                          "name": "Бонусы",
                          "code": "Currency1",
                          "uid": "1f24174f-bfdb-4019-a3e7-4fb088b4a7a7",
                          "externalId": "1f24174f-bfdb-4019-a3e7-4fb088b4a7a7",
                          "imageId": null,
                          "description": "Общая внутрисистемная валюта",
                          "isDeleted": false,
                          "nameCases": {
                            "nominative": "бонус",
                            "genitive": "бонуса",
                            "plural": "бонусов",
                            "abbreviation": "бнс."
                          }
                        },
                        "amount": 110.0,
                        "notActivatedAmount": 20.0,
                        "accountIsBlocked": false,
                        "lifeTimesByTime": [
                          {
                            "amount": 0.0,
                            "date": "2018-06-08T06:54:33.806Z"
                          },
                          {
                            "amount": -10.0,
                            "date": "2018-06-09T07:54:33.806Z"
                          },
                          {
                            "amount": 20.0,
                            "date": "2018-06-10T08:54:33.806Z"
                          }
                        ],
                        "lifeTimesByPeriod": [
                          {
                            "activationAmount": 0.0,
                            "expirationAmount": 0.0,
                            "period": "FromWeekToMonth"
                          },
                          {
                            "activationAmount": 0.0,
                            "expirationAmount": 10.0,
                            "period": "FromMonthToYear"
                          },
                          {
                            "activationAmount": 20.0,
                            "expirationAmount": 0.0,
                            "period": "FromYear"
                          }
                        ]
                      },
                      {
                        "currency": {
                          "id": 4,
                          "name": "Приветственные бонусы",
                          "code": "Currency3",
                          "uid": "572fa942-fd58-1cd8-60b5-f16b9cfc3022",
                          "externalId": "572fa942-fd58-1cd8-60b5-f16b9cfc3022",
                          "imageId": null,
                          "description": "Приветственные бонусы",
                          "isDeleted": false,
                          "nameCases": {
                            "nominative": "Приветственные бонусы",
                            "genitive": "Приветственного бонуса",
                            "plural": "Приветственных бонусов",
                            "abbreviation": "Прив.бнс."
                          }
                        },
                        "amount": 100.0000,
                        "notActivatedAmount": 0.0,
                        "accountIsBlocked": false,
                        "lifeTimesByTime": [],
                        "lifeTimesByPeriod": [
                          {
                            "activationAmount": 0.0,
                            "expirationAmount": -100.0000,
                            "period": "FromWeekToMonth"
                          },
                          {
                            "activationAmount": 0.0,
                            "expirationAmount": 0.0,
                            "period": "FromMonthToYear"
                          },
                          {
                            "activationAmount": 0.0,
                            "expirationAmount": 0.0,
                            "period": "FromYear"
                          }
                        ]
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
                JSON
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $result = $loymax->publicApi('validAccessToken')->user()->getDetailedBalance();

        self::assertSame(1, $result[0]->currency->id);
        self::assertSame('Бонусы', $result[0]->currency->name);
        self::assertSame(110.0, $result[0]->amount);
        self::assertSame(20.0, $result[0]->notActivatedAmount);
        self::assertFalse($result[0]->accountIsBlocked);
        self::assertCount(3, $result[0]->lifeTimesByTime);
        self::assertSame(0.0, $result[0]->lifeTimesByTime[0]->amount);
        self::assertSame(
            (new DateTimeImmutable('2018-06-08 06:54:33.806 +00:00'))->format('c'),
            $result[0]->lifeTimesByTime[0]->date->format('c')
        );
        self::assertSame(-10.0, $result[0]->lifeTimesByTime[1]->amount);
        self::assertSame(
            (new DateTimeImmutable('2018-06-09 07:54:33.806 +00:00'))->format('c'),
            $result[0]->lifeTimesByTime[1]->date->format('c')
        );
        self::assertSame(20.0, $result[0]->lifeTimesByTime[2]->amount);
        self::assertSame(
            (new DateTimeImmutable('2018-06-10 08:54:33.806 +00:00'))->format('c'),
            $result[0]->lifeTimesByTime[2]->date->format('c')
        );
        self::assertCount(3, $result[0]->lifeTimesByPeriod);
        self::assertSame(0.0, $result[0]->lifeTimesByPeriod[0]->activationAmount);
        self::assertSame(0.0, $result[0]->lifeTimesByPeriod[0]->expirationAmount);
        self::assertSame(Period::FROM_WEEK_TO_MONTH, $result[0]->lifeTimesByPeriod[0]->period);
        self::assertSame(0.0, $result[0]->lifeTimesByPeriod[1]->activationAmount);
        self::assertSame(10.0, $result[0]->lifeTimesByPeriod[1]->expirationAmount);
        self::assertSame(Period::FROM_MONTH_TO_YEAR, $result[0]->lifeTimesByPeriod[1]->period);
        self::assertSame(20.0, $result[0]->lifeTimesByPeriod[2]->activationAmount);
        self::assertSame(0.0, $result[0]->lifeTimesByPeriod[2]->expirationAmount);
        self::assertSame(Period::FROM_YEAR, $result[0]->lifeTimesByPeriod[2]->period);

        self::assertSame(4, $result[1]->currency->id);
        self::assertSame('Приветственные бонусы', $result[1]->currency->name);
        self::assertSame(100.0, $result[1]->amount);
        self::assertSame(0.0, $result[1]->notActivatedAmount);
        self::assertFalse($result[1]->accountIsBlocked);
        self::assertCount(0, $result[1]->lifeTimesByTime);
        self::assertCount(3, $result[1]->lifeTimesByPeriod);
        self::assertSame(0.0, $result[1]->lifeTimesByPeriod[0]->activationAmount);
        self::assertSame(-100.0, $result[1]->lifeTimesByPeriod[0]->expirationAmount);
        self::assertSame(Period::FROM_WEEK_TO_MONTH, $result[1]->lifeTimesByPeriod[0]->period);
        self::assertSame(0.0, $result[1]->lifeTimesByPeriod[1]->activationAmount);
        self::assertSame(0.0, $result[1]->lifeTimesByPeriod[1]->expirationAmount);
        self::assertSame(Period::FROM_MONTH_TO_YEAR, $result[1]->lifeTimesByPeriod[1]->period);
        self::assertSame(0.0, $result[1]->lifeTimesByPeriod[2]->activationAmount);
        self::assertSame(0.0, $result[1]->lifeTimesByPeriod[2]->expirationAmount);
        self::assertSame(Period::FROM_YEAR, $result[1]->lifeTimesByPeriod[2]->period);
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
        $loymax->publicApi()->user()->getDetailedBalance();
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
        $loymax->publicApi('validAccessToken')->user()->getDetailedBalance();
    }
}
