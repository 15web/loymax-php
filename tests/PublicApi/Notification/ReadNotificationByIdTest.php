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
#[TestDox('Прочтение конкретного оповещения')]
final class ReadNotificationByIdTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSuccess(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                    "data": {
                        "id": 7,
                        "title": "Принимай участие в розыгрыше🎉",
                        "body": "Успей принять участие в розыгрыше 1000 баллов на карту лояльности Супермаркет, подробнее по ссылке https://example.com/",
                        "summary": "Успей принять участие в розыгрыше 1000 баллов на карту лояльности Супермаркет, подробнее по ссылке https://example.com/",
                        "creationDate": "2024-05-06T13:01:09Z",
                        "isReaded": true,
                        "imageId": "f1d06c60-ae4f-4b05-952e-3bdb314a5e1b",
                        "imageUrl": null
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
        $result = $loymax->publicApi('validAccessToken')->notification()->readNotificationById(7);

        self::assertSame(7, $result->id);
        self::assertSame('Принимай участие в розыгрыше🎉', $result->title);
        self::assertSame(
            'Успей принять участие в розыгрыше 1000 баллов на карту лояльности Супермаркет, подробнее по ссылке https://example.com/',
            $result->body
        );
        self::assertSame(
            'Успей принять участие в розыгрыше 1000 баллов на карту лояльности Супермаркет, подробнее по ссылке https://example.com/',
            $result->summary
        );
        self::assertSame(
            '2024-05-06T13:01:09Z',
            (new DateTimeImmutable($result->creationDate))->format('Y-m-d\TH:i:sp')
        );
        self::assertTrue($result->isRead);
    }

    #[TestDox('Оповещение не найдено')]
    public function testNotFound(): void
    {
        $this->expectException(InvalidResponse::class);
        $this->expectExceptionMessage('Оповещение не найдено');

        $mockResponse = new Response(
            body: <<<'JSON'
                {
                    "result": {
                        "state": "Error",
                        "httpCode": 400,
                        "message": "Оповещение не найдено",
                        "messageCode": null,
                        "exception": null,
                        "validationErrors": null
                    }
                }
                JSON
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi('validAccessToken')->notification()->readNotificationById(12345);
    }

    #[TestDox('Неавторизованный запрос')]
    public function testUnauthorized(): void
    {
        $this->expectException(Unauthorized::class);

        $mockResponse = new Response(
            status: 401,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi('invalidAccessToken')->notification()->readNotificationById(7);
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
                JSON
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi('validAccessToken')->notification()->readNotificationById(7);
    }
}
