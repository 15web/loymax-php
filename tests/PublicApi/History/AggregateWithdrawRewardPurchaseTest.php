<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\History;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Агрегация сумм покупок, списанных и начисленных бонусов')]
final class AggregateWithdrawRewardPurchaseTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSuccess(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                    "data": {
                        "purchaseAmount": [
                            {
                                "amount": {
                                    "amount": 1625.8700,
                                    "currency": "руб.",
                                    "currencyInfo": {
                                        "id": 2,
                                        "name": "Рубли",
                                        "code": "Currency2",
                                        "uid": "718ae69b-76be-413f-ad19-7b7e02e4a438",
                                        "externalId": "718ae69b-76be-413f-ad19-7b7e02e4a438",
                                        "imageId": null,
                                        "description": "Денежная единица Российской Федерации",
                                        "isDeleted": false,
                                        "nameCases": {
                                            "nominative": "рубль",
                                            "genitive": "рубля",
                                            "plural": "рублей",
                                            "abbreviation": "руб."
                                        }
                                    }
                                }
                            }
                        ],
                        "withdraws": [
                            {
                                "withdrawType": "Loymax.History.Mobile.Contract.Bonuses",
                                "amount": {
                                    "amount": -95.5000,
                                    "currency": "Прив.бнс.",
                                    "currencyInfo": {
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
                                    }
                                }
                            }
                        ],
                        "rewards": [
                            {
                                "rewardType": "Loymax.History.Mobile.Contract.Bonus",
                                "amount": {
                                    "amount": 61.2000,
                                    "currency": "бнс.",
                                    "currencyInfo": {
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
                                    }
                                }
                            },
                            {
                                "rewardType": "Loymax.History.Mobile.Contract.Bonus",
                                "amount": {
                                    "amount": 100.0000,
                                    "currency": "Прив.бнс.",
                                    "currencyInfo": {
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
                                    }
                                }
                            }
                        ],
                        "purchaseCount": 2
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
        $result = $loymax->publicApi('validAccessToken')->history()->getAggregateWithdrawRewardPurchase();

        self::assertCount(1, $result->purchaseAmount);
        self::assertCount(1, $result->withdraws);
        self::assertCount(2, $result->rewards);

        $purchases = $result->purchaseAmount;
        self::assertSame(1625.8700, $purchases[0]->amount->amount);
        self::assertSame(2, $purchases[0]->amount->currencyInfo->id);
        self::assertSame('Рубли', $purchases[0]->amount->currencyInfo->name);
        self::assertSame('Currency2', $purchases[0]->amount->currencyInfo->code);

        $withdraws = $result->withdraws;
        self::assertSame(-95.5000, $withdraws[0]->amount->amount);
        self::assertSame(4, $withdraws[0]->amount->currencyInfo->id);
        self::assertSame('Приветственные бонусы', $withdraws[0]->amount->currencyInfo->name);
        self::assertSame('Currency3', $withdraws[0]->amount->currencyInfo->code);

        $rewards = $result->rewards;
        self::assertSame(61.2000, $rewards[0]->amount->amount);
        self::assertSame(1, $rewards[0]->amount->currencyInfo->id);
        self::assertSame('Бонусы', $rewards[0]->amount->currencyInfo->name);
        self::assertSame('Currency1', $rewards[0]->amount->currencyInfo->code);
        self::assertSame(100.0000, $rewards[1]->amount->amount);
        self::assertSame(4, $rewards[1]->amount->currencyInfo->id);
        self::assertSame('Приветственные бонусы', $rewards[1]->amount->currencyInfo->name);
        self::assertSame('Currency3', $rewards[1]->amount->currencyInfo->code);
    }

    #[TestDox('Записи не найдены')]
    public function testEmptyCollection(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "purchaseAmount": [],
                    "withdraws": [],
                    "rewards": [],
                    "purchaseCount": 0
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
        $result = $loymax->publicApi('validAccessToken')->history()->getAggregateWithdrawRewardPurchase();

        self::assertCount(0, $result->purchaseAmount);
        self::assertCount(0, $result->withdraws);
        self::assertCount(0, $result->rewards);
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
        $loymax->publicApi('invalidAccessToken')->history()->getAggregateWithdrawRewardPurchase();
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
        $loymax->publicApi('validAccessToken')->history()->getAggregateWithdrawRewardPurchase();
    }
}
