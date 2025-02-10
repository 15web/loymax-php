<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\Offer;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Возвращает информацию о таргетированном контенте по внутреннему идентификатору')]
final class GetOfferByIdTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSuccess(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                    "data": {
                        "id": 1,
                        "priority": 70,
                        "title": "Программа лояльности Супермаркет маркет🧀",
                        "description": "•\tВозвращайте до 10% от стоимости покупки бонусами на карту.\n\n•\t",
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
                                "description": "Супермаркет",
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
        $result = $loymax->publicApi('validAccessToken')->offer()->getOfferById(1);

        $brands = $result->brands;
        $images = $result->images;

        self::assertSame(1, $result->id);
        self::assertSame('Программа лояльности Супермаркет маркет🧀', $result->title);
        self::assertSame("•\tВозвращайте до 10% от стоимости покупки бонусами на карту.\n\n•\t", $result->description);
        self::assertSame(25, $result->merchantsCount);
        self::assertSame('2024-02-22T00:00:00Z', $result->begin);
        self::assertNull($result->end);

        self::assertCount(1, $brands);
        self::assertSame('b77a6015-ac3c-53a8-2d47-5cc7be21e3f2', (string) $brands[0]->id);
        self::assertSame('Супермаркет', $brands[0]->name);
        self::assertSame('Супермаркет', $brands[0]->description);

        self::assertSame('8ac1ff0d-8243-4f29-ad3f-8f0066a11888', $images[0]->fileId);
    }

    #[TestDox('Успешный результат без авторизации')]
    public function testGuestSuccess(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                    "data": {
                        "id": 1,
                        "priority": 70,
                        "title": "Программа лояльности Супермаркет маркет🧀",
                        "description": "•\tВозвращайте до 10% от стоимости покупки бонусами на карту.\n\n•\t",
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
                                "description": "Супермаркет",
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
        $result = $loymax->publicApi()->offer()->getOfferById(1);

        $brands = $result->brands;
        $images = $result->images;

        self::assertSame(1, $result->id);
        self::assertSame('Программа лояльности Супермаркет маркет🧀', $result->title);
        self::assertSame("•\tВозвращайте до 10% от стоимости покупки бонусами на карту.\n\n•\t", $result->description);
        self::assertSame(25, $result->merchantsCount);
        self::assertSame('2024-02-22T00:00:00Z', $result->begin);

        self::assertCount(1, $brands);
        self::assertSame('b77a6015-ac3c-53a8-2d47-5cc7be21e3f2', (string) $brands[0]->id);
        self::assertSame('Супермаркет', $brands[0]->name);
        self::assertSame('Супермаркет', $brands[0]->description);

        self::assertSame('8ac1ff0d-8243-4f29-ad3f-8f0066a11888', $images[0]->fileId);
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
        $loymax->publicApi('validAccessToken')->offer()->getOfferById(1);
    }

    #[TestDox('Запрос завершился с ошибкой')]
    public function testFailed(): void
    {
        $this->expectException(InvalidResponse::class);
        $this->expectExceptionMessage('Request failed');

        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {},
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
        $loymax->publicApi('validAccessToken')->offer()->getOfferById(1);
    }

    #[TestDox('Запись не найдена')]
    public function testNotFound(): void
    {
        $this->expectException(InvalidResponse::class);
        $this->expectExceptionMessage('Не найден рекламный материал с указанным идентификатором 123 для пользователя 456');

        $mockResponse = new Response(
            body: <<<'JSON'
                {
                    "result": {
                        "state": "Error",
                        "httpCode": 400,
                        "message": "Не найден рекламный материал с указанным идентификатором 123 для пользователя 456",
                        "messageCode": "Business.Base",
                        "exception": null,
                        "validationErrors": null
                    }
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi('validAccessToken')->offer()->getOfferById(123);
    }

    #[TestDox('Запись не найдена, без авторизации')]
    public function testGuestNotFound(): void
    {
        $this->expectException(InvalidResponse::class);
        $this->expectExceptionMessage('Не найден рекламный материал с указанным идентификатором 123');

        $mockResponse = new Response(
            body: <<<'JSON'
                {
                    "result": {
                        "state": "Error",
                        "httpCode": 400,
                        "message": "Не найден рекламный материал с указанным идентификатором 123",
                        "messageCode": "Business.Base",
                        "exception": null,
                        "validationErrors": null
                    }
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi()->offer()->getOfferById(123);
    }
}
