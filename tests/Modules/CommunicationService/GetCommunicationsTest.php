<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\Modules\CommunicationService;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\Modules\CommunicationService\Response\OfferType;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Получение персональных предложений')]
final class GetCommunicationsTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSuccess(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data":  {
                    "items": [
                        {
                            "id": 1,
                            "communicationType": "Mobb_App",
                            "value": [
                                {
                                    "dateFrom": "2024-07-05T00:00:00Z",
                                    "dateTo": "2024-09-05T23:59:00Z",
                                    "goodsId": "34235",
                                    "name": "ТМ ВЕЛИКИЕ ЛУКИ Сыр полутвердый«Великолукский» 45% брус 3кг (5шт) (41.02)",
                                    "categoryName": null,
                                    "link": "https://loymax.ru",
                                    "images": [
                                        {
                                            "imageType": 0,
                                            "value": "https://market.loymax.tech/systemapi/api/Files/78bdd181-b728-abce-a5b3-681f6bbc2624",
                                            "data": null
                                        }
                                    ],
                                    "description": "БОНУСЫ за покупку товаров\n05.07.2024\nКешбэк действует по Вашей карте НазваниеКарты ***5357 в магазинах Магазин1 и Магазин2!",
                                    "regularPrice": null,
                                    "regularPriceDescription": null,
                                    "offers": [
                                        {
                                            "value": 15.0,
                                            "valueDescription": null,
                                            "border": null,
                                            "borderDescription": null,
                                            "displayOrder": 1,
                                            "offerType": "CashbackPercentGoods",
                                            "description": null,
                                            "data": null
                                        }
                                    ],
                                    "data": null
                                },
                                {
                                    "dateFrom": "2024-07-05T00:00:00Z",
                                    "dateTo": "2024-09-05T23:59:00Z",
                                    "goodsId": "34215",
                                    "name": "ТМ ВЕЛИКИЕ ЛУКИ Сыр полутвердый«Великолукский» с массовой долей жира в сухом веществе 45% брус 1кг (4шт)",
                                    "categoryName": null,
                                    "link": "https://loymax.ru",
                                    "images": [
                                        {
                                            "imageType": 0,
                                            "value": "https://market.loymax.tech/systemapi/api/Files/78bdd181-b728-abce-a5b3-681f6bbc2624",
                                            "data": null
                                        }
                                    ],
                                    "description": "БОНУСЫ за покупку товаров\n05.07.2024\nКешбэк действует по Вашей карте НазваниеКарты ***5357 в магазинах Магазин1 и Магазин2!",
                                    "regularPrice": 100,
                                    "regularPriceDescription": null,
                                    "offers": [
                                        {
                                            "value": 5.0,
                                            "valueDescription": null,
                                            "border": 1000.0,
                                            "borderDescription": null,
                                            "displayOrder": 2,
                                            "offerType": "CashbackPercentGoods",
                                            "description": null,
                                            "data": null
                                        }
                                    ],
                                    "data": null
                                }
                            ]
                        }
                    ],
                    "proposalName": "ML1_Mobile",
                    "sentDate": "2024-07-11T09:36:50.7021266+00:00",
                    "validDate": "9999-12-31T23:59:59.9999999",
                    "state": "Delivered"
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
        $result = $loymax->communicationService('validAccessToken')->getCommunications();

        self::assertSame('ML1_Mobile', $result->proposalName);
        self::assertSame('2024-07-11T09:36:50Z', $result->sentDate?->format('Y-m-d\TH:i:sp'));
        self::assertSame('9999-12-31T23:59:59Z', $result->validDate?->format('Y-m-d\TH:i:sp'));
        self::assertSame('Delivered', $result->state);

        self::assertNotNull($result->items);
        self::assertCount(1, $result->items);
        self::assertSame(1, $result->items[0]->id);
        self::assertCount(2, $result->items[0]->value);
        self::assertSame(
            '2024-07-05T00:00:00Z',
            $result->items[0]->value[0]->dateFrom->format('Y-m-d\TH:i:sp'),
        );
        self::assertSame(
            '2024-09-05T23:59:00Z',
            $result->items[0]->value[0]->dateTo->format('Y-m-d\TH:i:sp'),
        );
        self::assertSame('34235', $result->items[0]->value[0]->goodsId);
        self::assertSame(
            'ТМ ВЕЛИКИЕ ЛУКИ Сыр полутвердый«Великолукский» 45% брус 3кг (5шт) (41.02)',
            $result->items[0]->value[0]->name,
        );
        self::assertNull($result->items[0]->value[0]->categoryName);
        self::assertCount(1, $result->items[0]->value[0]->images);
        self::assertSame(
            'https://market.loymax.tech/systemapi/api/Files/78bdd181-b728-abce-a5b3-681f6bbc2624',
            $result->items[0]->value[0]->images[0]->value,
        );
        self::assertSame(
            "БОНУСЫ за покупку товаров\n05.07.2024\nКешбэк действует по Вашей карте НазваниеКарты ***5357 в магазинах Магазин1 и Магазин2!",
            $result->items[0]->value[0]->description,
        );
        self::assertNull($result->items[0]->value[0]->regularPrice);
        self::assertNull($result->items[0]->value[0]->regularPriceDescription);
        self::assertCount(1, $result->items[0]->value[0]->offers);
        self::assertSame(15.0, $result->items[0]->value[0]->offers[0]->value);
        self::assertNull($result->items[0]->value[0]->offers[0]->valueDescription);
        self::assertNull($result->items[0]->value[0]->offers[0]->border);
        self::assertNull($result->items[0]->value[0]->offers[0]->borderDescription);
        self::assertSame(1, $result->items[0]->value[0]->offers[0]->displayOrder);
        self::assertSame(OfferType::CashbackPercentGoods, $result->items[0]->value[0]->offers[0]->offerType);
        self::assertNull($result->items[0]->value[0]->offers[0]->description);

        self::assertSame(
            '2024-07-05T00:00:00Z',
            $result->items[0]->value[1]->dateFrom->format('Y-m-d\TH:i:sp'),
        );
        self::assertSame(
            '2024-09-05T23:59:00Z',
            $result->items[0]->value[1]->dateTo->format('Y-m-d\TH:i:sp'),
        );
        self::assertSame('34215', $result->items[0]->value[1]->goodsId);
        self::assertSame(
            'ТМ ВЕЛИКИЕ ЛУКИ Сыр полутвердый«Великолукский» с массовой долей жира в сухом веществе 45% брус 1кг (4шт)',
            $result->items[0]->value[1]->name,
        );
        self::assertNull($result->items[0]->value[1]->categoryName);
        self::assertCount(1, $result->items[0]->value[1]->images);
        self::assertSame(
            'https://market.loymax.tech/systemapi/api/Files/78bdd181-b728-abce-a5b3-681f6bbc2624',
            $result->items[0]->value[1]->images[0]->value,
        );
        self::assertSame(
            "БОНУСЫ за покупку товаров\n05.07.2024\nКешбэк действует по Вашей карте НазваниеКарты ***5357 в магазинах Магазин1 и Магазин2!",
            $result->items[0]->value[1]->description,
        );
        self::assertSame(100, $result->items[0]->value[1]->regularPrice);
        self::assertNull($result->items[0]->value[1]->regularPriceDescription);
        self::assertCount(1, $result->items[0]->value[1]->offers);
        self::assertSame(5.0, $result->items[0]->value[1]->offers[0]->value);
        self::assertNull($result->items[0]->value[1]->offers[0]->valueDescription);
        self::assertSame(1000.0, $result->items[0]->value[1]->offers[0]->border);
        self::assertNull($result->items[0]->value[1]->offers[0]->borderDescription);
        self::assertSame(2, $result->items[0]->value[1]->offers[0]->displayOrder);
        self::assertSame(OfferType::CashbackPercentGoods, $result->items[0]->value[1]->offers[0]->offerType);
        self::assertNull($result->items[0]->value[1]->offers[0]->description);
    }

    #[TestDox('Записей не найдено')]
    public function testEmptyCollection(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "items": null,
                    "proposalName": null,
                    "sentDate": null,
                    "validDate": null,
                    "state": null
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
        $result = $loymax->communicationService('validAccessToken')->getCommunications();

        self::assertNull($result->items);
        self::assertNull($result->proposalName);
        self::assertNull($result->sentDate);
        self::assertNull($result->validDate);
        self::assertNull($result->state);
    }

    #[TestDox('Неавторизованный запрос')]
    public function testUnauthorized(): void
    {
        $this->expectException(InvalidResponse::class);
        $this->expectExceptionMessage('Ошибка при аутентификация пользователя. Токен просрочен или недействителен');

        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": null,
                  "result": {
                    "state": "Fail",
                    "message": "Ошибка при аутентификация пользователя. Токен просрочен или недействителен.",
                    "messageCode": null,
                    "exception": null,
                    "validationErrors": null
                  }
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->communicationService('invalidAccessToken')->getCommunications();
    }

    #[TestDox('Запрос завершился с ошибкой')]
    public function testFailed(): void
    {
        $this->expectException(InvalidResponse::class);
        $this->expectExceptionMessage('Request failed');

        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": null,
                  "result": {
                    "state": "Fail",
                    "message": "Request failed",
                    "messageCode": null,
                    "exception": null,
                    "validationErrors": null
                  }
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->communicationService('validAccessToken')->getCommunications();
    }
}
