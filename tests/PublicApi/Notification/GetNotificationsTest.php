<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\Notification;

use DateTimeImmutable;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Возвращает список оповещений')]
final class GetNotificationsTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSuccess(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                    "data": [
                        {
                            "id": 23577,
                            "title": "Возвращайтесь, мы соскучились 💕",
                            "body": "Елена , дарим вам скидку 3% на следующую покупку, ваш Супермаркет🧀",
                            "summary": "Елена , дарим вам скидку 3% на следующую покупку, ваш Супермаркет🧀",
                            "creationDate": "2024-05-04T07:00:06Z",
                            "isReaded": false,
                            "imageId": null,
                            "imageUrl": ""
                        },
                        {
                            "id": 13664,
                            "title": "Начисление скидки на покупку",
                            "body": "Начисление скидки на сумму 34.36. Карта ***5035. Баланс 61.20",
                            "summary": "Начисление скидки на сумму 34.36. Карта ***5035. Баланс 61.20",
                            "creationDate": "2024-04-13T09:44:47Z",
                            "isReaded": true,
                            "imageId": null,
                            "imageUrl": null
                        },
                        {
                            "id": 13663,
                            "title": "Оплата покупки",
                            "body": "Оплата на сумму 95.50. Карта ***5035. Баланс 4.50",
                            "summary": null,
                            "creationDate": "2024-04-13T09:44:27Z",
                            "isReaded": true,
                            "imageId": null,
                            "imageUrl": null
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
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $result = $loymax->publicApi('validAccessToken')->notification()->getNotifications();

        self::assertCount(3, $result);

        self::assertSame(23577, $result[0]->id);
        self::assertSame('Возвращайтесь, мы соскучились 💕', $result[0]->title);
        self::assertSame('Елена , дарим вам скидку 3% на следующую покупку, ваш Супермаркет🧀', $result[0]->body);
        self::assertSame('Елена , дарим вам скидку 3% на следующую покупку, ваш Супермаркет🧀', $result[0]->summary);
        self::assertSame(
            '2024-05-04T07:00:06Z',
            (new DateTimeImmutable($result[0]->creationDate))->format('Y-m-d\TH:i:sp'),
        );
        self::assertFalse($result[0]->isRead);

        self::assertSame(13664, $result[1]->id);
        self::assertSame('Начисление скидки на покупку', $result[1]->title);
        self::assertSame('Начисление скидки на сумму 34.36. Карта ***5035. Баланс 61.20', $result[1]->body);
        self::assertSame('Начисление скидки на сумму 34.36. Карта ***5035. Баланс 61.20', $result[1]->summary);
        self::assertSame(
            '2024-04-13T09:44:47Z',
            (new DateTimeImmutable($result[1]->creationDate))->format('Y-m-d\TH:i:sp'),
        );
        self::assertTrue($result[1]->isRead);

        self::assertSame(13663, $result[2]->id);
        self::assertSame('Оплата покупки', $result[2]->title);
        self::assertSame('Оплата на сумму 95.50. Карта ***5035. Баланс 4.50', $result[2]->body);
        self::assertNull($result[2]->summary);
        self::assertSame(
            '2024-04-13T09:44:27Z',
            (new DateTimeImmutable($result[2]->creationDate))->format('Y-m-d\TH:i:sp'),
        );
        self::assertTrue($result[2]->isRead);
    }

    #[TestDox('Успешный результат, пагинация')]
    public function testPagination(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                    "data": [
                        {
                            "id": 13664,
                            "title": "Начисление скидки на покупку",
                            "body": "Начисление скидки на сумму 34.36. Карта ***5035. Баланс 61.20",
                            "summary": "Начисление скидки на сумму 34.36. Карта ***5035. Баланс 61.20",
                            "creationDate": "2024-04-13T09:44:47Z",
                            "isReaded": true,
                            "imageId": null,
                            "imageUrl": null
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
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $result = $loymax->publicApi('validAccessToken')->notification()->getNotifications(from: 1, count: 1);

        self::assertCount(1, $result);

        self::assertSame(13664, $result[0]->id);
        self::assertSame('Начисление скидки на покупку', $result[0]->title);
        self::assertSame('Начисление скидки на сумму 34.36. Карта ***5035. Баланс 61.20', $result[0]->body);
        self::assertSame('Начисление скидки на сумму 34.36. Карта ***5035. Баланс 61.20', $result[0]->summary);
        self::assertSame(
            '2024-04-13T09:44:47Z',
            (new DateTimeImmutable($result[0]->creationDate))->format('Y-m-d\TH:i:sp'),
        );
        self::assertTrue($result[0]->isRead);
    }

    #[TestDox('Оповещения не найдены')]
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
        $result = $loymax->publicApi('validAccessToken')->notification()->getNotifications();

        self::assertEmpty($result);
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
        $loymax->publicApi('invalidAccessToken')->notification()->getNotifications();
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
        $loymax->publicApi('validAccessToken')->notification()->getNotifications();
    }
}
