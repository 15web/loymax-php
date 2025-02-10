<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\Offer;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\PublicApi\Offer\Request\OfferType;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Возвращает информацию о таргетированном контенте')]
final class GetOffersTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSuccess(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": [
                      {
                        "id": 1,
                        "priority": 70,
                        "title": "Программа лояльности",
                        "description": "•\tВозвращайте до 10% от стоимости покупки бонусами на карту.\n",
                        "shortDescription": null,
                        "begin": "2024-02-22T00:00:00Z",
                        "end": "2025-02-22T00:00:00Z",
                        "rewardThumbnail": null,
                        "rewardImageId": null,
                        "brandIds": [
                            "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2"
                        ],
                        "brands": [
                            {
                                "code": "Супермаркет",
                                "mainId": null,
                                "id": "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2",
                                "uid": "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2",
                                "name": "Супермаркет",
                                "description": "Описание бренда",
                                "fullDescription": null,
                                "url": null,
                                "images": [
                                    {
                                        "fileId": "6b8bbda1-1694-4048-a712-ece008337e95",
                                        "description": "marker"
                                    }
                                ]
                            }
                        ],
                        "brandId": "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2",
                        "images": [
                            {
                                "fileId": "8ac1ff0d-8243-4f29-ad3f-8f0066a11888",
                                "description": "700x350"
                            }
                        ],
                        "instructions": [],
                        "merchantsCount": 25
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
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $result = $loymax->publicApi('validAccessToken')->offer()->getOffer();

        $brands = $result[0]->brands;
        $images = $result[0]->images;

        self::assertCount(1, $result);
        self::assertSame(1, $result[0]->id);
        self::assertSame('Программа лояльности', $result[0]->title);
        self::assertSame("•\tВозвращайте до 10% от стоимости покупки бонусами на карту.\n", $result[0]->description);
        self::assertSame(25, $result[0]->merchantsCount);

        self::assertSame('2024-02-22T00:00:00Z', $result[0]->begin);
        self::assertSame('2025-02-22T00:00:00Z', $result[0]->end);

        self::assertCount(1, $brands);
        self::assertSame('b77a6015-ac3c-53a8-2d47-5cc7be21e3f2', (string) $brands[0]->id);
        self::assertSame('Супермаркет', $brands[0]->name);
        self::assertSame('Описание бренда', $brands[0]->description);

        self::assertCount(1, $images);
        self::assertSame('8ac1ff0d-8243-4f29-ad3f-8f0066a11888', $images[0]->fileId);
    }

    #[TestDox('Успешный результат без авторизации')]
    public function testGuestSuccess(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": [
                      {
                        "id": 1,
                        "priority": 70,
                        "title": "Программа лояльности",
                        "description": "•\tВозвращайте до 10% от стоимости покупки бонусами на карту.\n",
                        "shortDescription": null,
                        "begin": "2024-02-22T00:00:00Z",
                        "end": "2025-02-22T00:00:00Z",
                        "rewardThumbnail": null,
                        "rewardImageId": null,
                        "brandIds": [
                            "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2"
                        ],
                        "brands": [
                            {
                                "code": "Супермаркет",
                                "mainId": null,
                                "id": "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2",
                                "uid": "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2",
                                "name": "Супермаркет",
                                "description": "Описание бренда",
                                "fullDescription": null,
                                "url": null,
                                "images": [
                                    {
                                        "fileId": "6b8bbda1-1694-4048-a712-ece008337e95",
                                        "description": "marker"
                                    }
                                ]
                            }
                        ],
                        "brandId": "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2",
                        "images": [
                            {
                                "fileId": "8ac1ff0d-8243-4f29-ad3f-8f0066a11888",
                                "description": "700x350"
                            }
                        ],
                        "instructions": [],
                        "merchantsCount": 25
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
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $result = $loymax->publicApi()->offer()->getOffer();

        $brands = $result[0]->brands;
        $images = $result[0]->images;

        self::assertCount(1, $result);
        self::assertSame(1, $result[0]->id);
        self::assertSame('Программа лояльности', $result[0]->title);
        self::assertSame("•\tВозвращайте до 10% от стоимости покупки бонусами на карту.\n", $result[0]->description);
        self::assertSame(25, $result[0]->merchantsCount);
        self::assertSame('2024-02-22T00:00:00Z', $result[0]->begin);
        self::assertSame('2025-02-22T00:00:00Z', $result[0]->end);

        self::assertCount(1, $brands);
        self::assertSame('b77a6015-ac3c-53a8-2d47-5cc7be21e3f2', (string) $brands[0]->id);
        self::assertSame('Супермаркет', $brands[0]->name);
        self::assertSame('Описание бренда', $brands[0]->description);

        self::assertCount(1, $images);
        self::assertSame('8ac1ff0d-8243-4f29-ad3f-8f0066a11888', $images[0]->fileId);
    }

    #[TestDox('Успешный результат с дополнительными параметрами')]
    public function testFilter(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": [
                      {
                        "id": 11,
                        "priority": 70,
                        "title": "День рождения",
                        "description": "Возвращайте до 20% от стоимости покупки бонусами на карту.",
                        "shortDescription": null,
                        "begin": "2024-02-22T00:00:00Z",
                        "end": null,
                        "rewardThumbnail": null,
                        "rewardImageId": null,
                        "brandIds": [
                            "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2"
                        ],
                        "brands": [
                            {
                                "code": "Супермаркет",
                                "mainId": null,
                                "id": "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2",
                                "uid": "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2",
                                "name": "Супермаркет",
                                "description": "Описание бренда",
                                "fullDescription": null,
                                "url": null,
                                "images": [
                                    {
                                        "fileId": "6b8bbda1-1694-4048-a712-ece008337e95",
                                        "description": "marker"
                                    }
                                ]
                            }
                        ],
                        "brandId": "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2",
                        "images": [
                            {
                                "fileId": "8ac1ff0d-8243-4f29-ad3f-8f0066a11888",
                                "description": "700x350"
                            }
                        ],
                        "instructions": [],
                        "merchantsCount": 125
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
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $result = $loymax->publicApi('validAccessToken')->offer()->getOffer(
            type: OfferType::PersonalOffer,
            from: 10,
            count: 1,
            merchantId: 1,
        );

        $brands = $result[0]->brands;
        $images = $result[0]->images;

        self::assertCount(1, $result);
        self::assertSame(11, $result[0]->id);
        self::assertSame('День рождения', $result[0]->title);
        self::assertSame('Возвращайте до 20% от стоимости покупки бонусами на карту.', $result[0]->description);
        self::assertSame(125, $result[0]->merchantsCount);
        self::assertSame('2024-02-22T00:00:00Z', $result[0]->begin);

        self::assertCount(1, $brands);
        self::assertSame('b77a6015-ac3c-53a8-2d47-5cc7be21e3f2', (string) $brands[0]->id);
        self::assertSame('Супермаркет', $brands[0]->name);
        self::assertSame('Описание бренда', $brands[0]->description);

        self::assertCount(1, $images);
        self::assertSame('8ac1ff0d-8243-4f29-ad3f-8f0066a11888', $images[0]->fileId);
    }

    #[TestDox('Успешный результат без токена авторизации')]
    public function testWithoutAuthToken(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": [
                      {
                        "id": 1,
                        "priority": 70,
                        "title": "Программа лояльности",
                        "description": "•\tВозвращайте до 10% от стоимости покупки бонусами на карту.\n",
                        "shortDescription": null,
                        "begin": "2024-02-22T00:00:00Z",
                        "end": null,
                        "rewardThumbnail": null,
                        "rewardImageId": null,
                        "brandIds": [
                            "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2"
                        ],
                        "brands": [
                            {
                                "code": "Супермаркет",
                                "mainId": null,
                                "id": "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2",
                                "uid": "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2",
                                "name": "Супермаркет",
                                "description": "Описание бренда",
                                "fullDescription": null,
                                "url": null,
                                "images": [
                                    {
                                        "fileId": "6b8bbda1-1694-4048-a712-ece008337e95",
                                        "description": "marker"
                                    }
                                ]
                            }
                        ],
                        "brandId": "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2",
                        "images": [
                            {
                                "fileId": "8ac1ff0d-8243-4f29-ad3f-8f0066a11888",
                                "description": "700x350"
                            }
                        ],
                        "instructions": [],
                        "merchantsCount": 25
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
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $result = $loymax->publicApi()->offer()->getOffer();

        $brands = $result[0]->brands;
        $images = $result[0]->images;

        self::assertCount(1, $result);
        self::assertSame(1, $result[0]->id);
        self::assertSame('Программа лояльности', $result[0]->title);
        self::assertSame("•\tВозвращайте до 10% от стоимости покупки бонусами на карту.\n", $result[0]->description);
        self::assertSame(25, $result[0]->merchantsCount);
        self::assertSame('2024-02-22T00:00:00Z', $result[0]->begin);

        self::assertCount(1, $brands);
        self::assertSame('b77a6015-ac3c-53a8-2d47-5cc7be21e3f2', (string) $brands[0]->id);
        self::assertSame('Супермаркет', $brands[0]->name);
        self::assertSame('Описание бренда', $brands[0]->description);

        self::assertCount(1, $images);
        self::assertSame('8ac1ff0d-8243-4f29-ad3f-8f0066a11888', $images[0]->fileId);
    }

    #[TestDox('Записей не найдено')]
    public function testEmptyCollection(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": [],
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
        $result = $loymax->publicApi('validAccessToken')->offer()->getOffer();

        self::assertSame([], $result);
    }

    #[TestDox('Фильтр по несуществующей торговой точке')]
    public function testFilterEmptyCollection(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                    "data": [],
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
        $result = $loymax->publicApi('validAccessToken')->offer()->getOffer();

        self::assertSame([], $result);
    }

    #[TestDox('Запрос персональных предложений без авторизации')]
    public function testUnauthorized(): void
    {
        $this->expectException(Unauthorized::class);

        $mockResponse = new Response(
            status: 401,
            body: <<<'JSON'
                {
                  "message": "Authorization has been denied for this request."
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi()->offer()->getOffer(
            type: OfferType::PersonalOffer,
        );
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
        $loymax->publicApi('validAccessToken')->offer()->getOffer();
    }
}
