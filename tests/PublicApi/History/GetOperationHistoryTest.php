<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\History;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\PublicApi\History\Response\OperationType;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Получение истории операций программы лояльности')]
final class GetOperationHistoryTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSuccess(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "allCount": 2,
                    "rows": [
                        {
                            "id": "b1ea8b73-db07-47ab-8dd8-9551a6fa1c44",
                            "dateTime": "2024-04-16T13:00:31+00:00",
                            "type": "RewardData",
                            "userId": null,
                            "identity": "79883198266",
                            "description": "Завершение регистрации",
                            "location": null,
                            "partnerId": "104eaad2-933c-3c1c-294c-21f5f928f4ca",
                            "brandId": null,
                            "brand": null,
                            "data": {
                                "$type": "Loymax.History.UI.Model.RewardDataModel, Loymax.History.UI.Model",
                                "offerExternalId": "eb1d07e0-116e-4dd9-93bf-23b25c31a751",
                                "rewardType": "Bonus",
                                "description": null,
                                "positionInfo": [],
                                "amount": {
                                    "amount": 100.0,
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
                        },
                        {
                            "id": "583fa901-1403-4729-ac81-7c5de8611a3d",
                            "dateTime": "2024-06-18T14:21:29+00:00",
                            "type": "PurchaseData",
                            "userId": 18177,
                            "identity": null,
                            "description": "г. Раменское, Привокзальная площадь, 1а",
                            "location": {
                                "id": 16,
                                "locationId": "4507d9a1-2c83-fbc5-1066-42aed64e2a0d",
                                "description": "г. Раменское, Привокзальная площадь, 1а",
                                "latitude": 55.56528,
                                "longitude": 38.227358,
                                "region": null,
                                "city": {
                                    "id": 9,
                                    "region": null,
                                    "name": "Раменское",
                                    "prefix": "г."
                                },
                                "street": "Привокзальная площадь",
                                "house": "1а",
                                "building": null,
                                "office": null
                            },
                            "partnerId": "104eaad2-933c-3c1c-294c-21f5f928f4ca",
                            "brandId": "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2",
                            "brand": {
                                "externalId": "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2",
                                "uid": "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2",
                                "name": "Супермаркет",
                                "images": [
                                    {
                                        "fileId": "6b8bbda1-1694-4048-a712-ece008337e95",
                                        "description": "marker"
                                    }
                                ]
                            },
                            "data": {
                                "$type": "Loymax.History.UI.Model.HistoryPurchaseDataModel, Loymax.History.UI.Model",
                                "externalPurchaseId": "4C4BA518827E47F6BA76677C7F69C35A",
                                "chequeItems": [
                                    {
                                        "positionId": 1,
                                        "description": "ТМ Супермаркет Сыр полутвердый «Kilt Молодой/Килт Молодой» с массовой долей жира в сухом веществе 45% брус 3 кг (5шт) (4шт)",
                                        "count": 0.342,
                                        "unit": null,
                                        "amount": 273.2600,
                                        "itemId": "34277",
                                        "commonCode": null
                                    },
                                    {
                                        "positionId": 2,
                                        "description": "ТМ ВЕЛИКИЕ ЛУКИ Сыр полутвердый «Maasdam/Маасдам» с массовой долей жира в сухом веществе 45% брус 1кг (4шт)",
                                        "count": 0.478,
                                        "unit": "кг",
                                        "amount": 452.6700,
                                        "itemId": "34211",
                                        "commonCode": null
                                    },
                                    {
                                        "positionId": 3,
                                        "description": "ТМ Супермаркет Масло сливочное \"Крестьянское\" массовая доля жира 72,5% 180г (12шт)***",
                                        "count": 1.000,
                                        "unit": "кг",
                                        "amount": 159.0000,
                                        "itemId": "30085",
                                        "commonCode": null
                                    },
                                    {
                                        "positionId": 4,
                                        "description": "ТМ Супермаркет Сыр твердый «Perla di Latte Intensiva» / «Перла ди Латте Интенсива» с массовой долей жира в сухом веществе 50% 1/8 головы (8шт)",
                                        "count": 0.357,
                                        "unit": "кг",
                                        "amount": 490.8800,
                                        "itemId": "34153",
                                        "commonCode": null
                                    }
                                ],
                                "chequeAdditionalAttributes": [],
                                "withdraws": [
                                    {
                                        "moneyAmount": 100.0000,
                                        "withdrawType": "Bonus",
                                        "description": null,
                                        "positionInfo": [],
                                        "amount": {
                                            "amount": -100.0000,
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
                                        "offerExternalId": "1a273eb2-fc3d-48b5-80e5-e340633cbeb9",
                                        "rewardType": "Bonus",
                                        "description": null,
                                        "positionInfo": [
                                            {
                                                "key": 1,
                                                "value": 5.0700
                                            },
                                            {
                                                "key": 2,
                                                "value": 8.4000
                                            },
                                            {
                                                "key": 3,
                                                "value": 2.9500
                                            },
                                            {
                                                "key": 4,
                                                "value": 9.1000
                                            }
                                        ],
                                        "amount": {
                                            "amount": 51.0400,
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
                                    }
                                ],
                                "isRefund": false,
                                "chequeNumber": "4900",
                                "amount": {
                                    "amount": 1375.8100,
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
                        }
                    ]
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
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $result = $loymax->publicApi('validAccessToken')->history()->getHistory(count: 1);

        self::assertSame(2, $result->allCount);
        self::assertCount(2, $result->rows);

        $operation = $result->rows[0];
        self::assertSame('b1ea8b73-db07-47ab-8dd8-9551a6fa1c44', (string) $operation->id);
        self::assertSame('Завершение регистрации', $operation->description);
        self::assertSame(OperationType::Reward, $operation->type);
        self::assertSame('2024-04-16T13:00:31+00:00', $operation->dateTime);
        self::assertSame('79883198266', $operation->identity);
        self::assertNull($operation->location);
        self::assertNull($operation->brand);

        $data = $operation->data;
        self::assertSame(100.0, $data->amount->amount);
        self::assertSame(4, $data->amount->currencyInfo->id);
        self::assertSame('Приветственные бонусы', $data->amount->currencyInfo->name);
        self::assertFalse($data->isRefund);
        self::assertEmpty($data->chequeItems);

        $operation = $result->rows[1];
        self::assertSame('583fa901-1403-4729-ac81-7c5de8611a3d', (string) $operation->id);
        self::assertSame('г. Раменское, Привокзальная площадь, 1а', $operation->description);
        self::assertSame(OperationType::Purchase, $operation->type);
        self::assertSame('2024-06-18T14:21:29+00:00', $operation->dateTime);
        self::assertNull($operation->identity);
        self::assertSame(16, $operation->location?->id);
        self::assertSame(
            'г. Раменское, Привокзальная площадь, 1а',
            $operation->location->description ?? null,
        );
        self::assertSame('b77a6015-ac3c-53a8-2d47-5cc7be21e3f2', (string) $operation->brand?->uid);
        self::assertSame('Супермаркет', $operation->brand?->name);

        $data = $operation->data;
        self::assertSame(1375.81, $data->amount->amount);
        self::assertSame(2, $data->amount->currencyInfo->id);
        self::assertSame('Рубли', $data->amount->currencyInfo->name);
        self::assertFalse($data->isRefund);
        self::assertCount(4, $data->chequeItems);

        $chequeItem = $data->chequeItems[0];
        self::assertSame(1, $chequeItem->positionId);
        self::assertSame(
            'ТМ Супермаркет Сыр полутвердый «Kilt Молодой/Килт Молодой» с массовой долей жира в сухом веществе 45% брус 3 кг (5шт) (4шт)',
            $chequeItem->description,
        );
        self::assertSame(273.26, $chequeItem->amount);
        self::assertSame(0.342, $chequeItem->count);
        self::assertNull($chequeItem->unit);

        $chequeItem = $data->chequeItems[1];
        self::assertSame(2, $chequeItem->positionId);
        self::assertSame(
            'ТМ ВЕЛИКИЕ ЛУКИ Сыр полутвердый «Maasdam/Маасдам» с массовой долей жира в сухом веществе 45% брус 1кг (4шт)',
            $chequeItem->description,
        );
        self::assertSame(452.67, $chequeItem->amount);
        self::assertSame(0.478, $chequeItem->count);
        self::assertSame('кг', $chequeItem->unit);

        $chequeItem = $data->chequeItems[2];
        self::assertSame(3, $chequeItem->positionId);
        self::assertSame(
            'ТМ Супермаркет Масло сливочное "Крестьянское" массовая доля жира 72,5% 180г (12шт)***',
            $chequeItem->description,
        );
        self::assertSame(159.0, $chequeItem->amount);
        self::assertSame(1.0, $chequeItem->count);
        self::assertSame('кг', $chequeItem->unit);

        $chequeItem = $data->chequeItems[3];
        self::assertSame(4, $chequeItem->positionId);
        self::assertSame(
            'ТМ Супермаркет Сыр твердый «Perla di Latte Intensiva» / «Перла ди Латте Интенсива» с массовой долей жира в сухом веществе 50% 1/8 головы (8шт)',
            $chequeItem->description,
        );
        self::assertSame(490.88, $chequeItem->amount);
        self::assertSame(0.357, $chequeItem->count);
        self::assertSame('кг', $chequeItem->unit);
    }

    #[TestDox('Записей не найдено')]
    public function testEmptyCollection(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "allCount": 0,
                    "rows": []
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
        $result = $loymax->publicApi('validAccessToken')->history()->getHistory(count: 1);

        self::assertSame(0, $result->allCount);
        self::assertSame([], $result->rows);
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
        $loymax->publicApi('validAccessToken')->history()->getHistory(count: 1);
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
        $loymax->publicApi('validAccessToken')->history()->getHistory(count: 1);
    }
}
