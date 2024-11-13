<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\Cards;

use DateTimeImmutable;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Выпуск виртуальной карту')]
final class EmitVirtualTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSuccess(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "id": 456,
                    "state": "Activated",
                    "number": "1011101100220011",
                    "barCode": "1011101100220011",
                    "block": false,
                    "expiryDate": "2024-03-25T12:18:27Z",
                    "cardCategory": {
                      "$type": "Loymax.Common.Contract.Model.Cards.CardCategoryInfo, Loymax.Common.Contract",
                      "description": null,
                      "cardCount": 0,
                      "id": 1,
                      "title": "Виртуальная карта",
                      "logicalName": "VirtualCard",
                      "images": []
                    }
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
        $result = $loymax->publicApi()->cards()->emitVirtual();

        /** @var DateTimeImmutable $expiryDate */
        $expiryDate = $result->expiryDate;

        self::assertSame(456, $result->id);
        self::assertSame('Activated', $result->state->value);
        self::assertSame('1011101100220011', $result->number);
        self::assertSame('1011101100220011', $result->barCode);
        self::assertFalse($result->block);
        self::assertSame('2024-03-25T12:18:27+00:00', $expiryDate->format(DateTimeImmutable::ATOM));
        self::assertSame(1, $result->cardCategory->id);
        self::assertSame('Loymax.Common.Contract.Model.Cards.CardCategoryInfo, Loymax.Common.Contract', $result->cardCategory->type);
        self::assertSame('Виртуальная карта', $result->cardCategory->title);
        self::assertNull($result->cardCategory->description);
        self::assertSame(0, $result->cardCategory->cardCount);
        self::assertSame('VirtualCard', $result->cardCategory->logicalName);
        self::assertSame([], $result->cardCategory->images);
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
        $loymax->publicApi()->cards()->emitVirtual();
    }

    #[TestDox('Не удалось выпустить карту')]
    public function testFailed(): void
    {
        $this->expectException(InvalidResponse::class);
        $this->expectExceptionMessage('Выдача виртуальных карт по запросу не предусмотрена.');

        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "result": {
                    "state": "Error",
                    "httpCode": 400,
                    "message": "Выдача виртуальных карт по запросу не предусмотрена.",
                    "messageCode": "Business.Base",
                    "exception": null,
                    "validationErrors": null
                  }
                }
                JSON
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi()->cards()->setCard(
            cardNumber: '1011101100220011',
            cvcCode: '123',
        );
    }
}
