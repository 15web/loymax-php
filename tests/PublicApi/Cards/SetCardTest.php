<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\Cards;

use DateTimeImmutable;
use GuzzleHttp\Psr7\Response;
use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\Test\TestCase;
use Webmozart\Assert\InvalidArgumentException;

/**
 * @internal
 */
#[TestDox('Прикрепление карты')]
final class SetCardTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSuccess(): void
    {
        $mockResponse = new Response(
            status: 201,
            body: <<<'JSON'
                {
                  "data": {
                    "$type": "Loymax.Mobile.Contract.Models.Cards.VirtualCardInfo, Loymax.Mobile.Contract",
                    "qrContent": "https://loymax.ru/join/0123456789",
                    "accumulated": {
                      "amount": 0.0,
                      "currency": "бнс.",
                      "currencyInfo": {
                        "id": 1,
                        "name": "Бонусы",
                        "code": "Currency1",
                        "uid": "0193260a-8040-7d4c-a916-0fbbad2a3e0d",
                        "externalId": "0193260a-8040-7d4c-a916-0fbbad2a3e0d",
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
                    },
                    "paid": {
                      "amount": 0.0,
                      "currency": "бнс.",
                      "currencyInfo": {
                        "id": 1,
                        "name": "Бонусы",
                        "code": "Currency1",
                        "uid": "0193260a-8040-7d4c-a916-0fbbad2a3e0d",
                        "externalId": "0193260a-8040-7d4c-a916-0fbbad2a3e0d",
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
                    },
                    "accumulatedInfo": [
                      {
                        "amount": 0.0000,
                        "currency": "Прив.бнс.",
                        "currencyInfo": {
                          "id": 4,
                          "name": "Приветственные бонусы",
                          "code": "Currency3",
                          "uid": "01932613-26ab-7ca1-8438-f3eba0a8443e",
                          "externalId": "01932613-26ab-7ca1-8438-f3eba0a8443e",
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
                    ],
                    "paidInfo": [
                      {
                        "amount": 0.0000,
                        "currency": "Прив.бнс.",
                        "currencyInfo": {
                          "id": 4,
                          "name": "Приветственные бонусы",
                          "code": "Currency3",
                          "uid": "01932613-26ab-7ca1-8438-f3eba0a8443e",
                          "externalId": "01932613-26ab-7ca1-8438-f3eba0a8443e",
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
                    ],
                    "cardActionAccessInfo": {
                      "canBlock": true,
                      "canReplace": false
                    },
                    "cardOwnerInfo": {
                      "phoneNumber": "***5055",
                      "email": null,
                      "firstName": "Ivan",
                      "lastName": "Ivanov",
                      "patronymicName": null,
                      "id": 123,
                      "personUid": "01932613-68ab-75cb-8c2f-7e8db1a1182d"
                    },
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
        $result = $loymax->publicApi()->cards()->setCard(
            cardNumber: '1011101100220011',
            cvcCode: '123',
        );

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
        $loymax->publicApi()->cards()->setCard(
            cardNumber: '1011101100220011',
            cvcCode: '123',
        );
    }

    #[TestDox('Не удалось привязать карту.')]
    public function testFailed(): void
    {
        $this->expectException(InvalidResponse::class);
        $this->expectExceptionMessage('Не удалось привязать карту.');

        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "result": {
                    "state": "Error",
                    "httpCode": 400,
                    "message": "Не удалось привязать карту.",
                    "messageCode": null,
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

    /**
     * @param array{
     *     cardNumber: non-empty-string,
     *     cvcCode: non-empty-string
     * } $data
     */
    #[DataProvider('invalidSetCardRequestDataProvider')]
    #[TestDox('Невалидные данные в запросе')]
    public function testInvalidRequestData(array $data): void
    {
        $this->expectException(InvalidArgumentException::class);

        $loymax = $this->createLoymaxClient();

        $loymax->publicApi('validToken')->cards()->setCard(
            cardNumber: $data['cardNumber'],
            cvcCode: $data['cvcCode'],
        );
    }

    public static function invalidSetCardRequestDataProvider(): Iterator
    {
        yield 'пустой запрос' => [['cardNumber' => '', 'cvcCode' => '']];

        yield 'пустой cardNumber' => [['cardNumber' => '', 'cvcCode' => '123']];

        yield 'невалидный cardNumber' => [['cardNumber' => 'fake', 'cvcCode' => '123']];

        yield 'пустой cvcCode' => [['cardNumber' => '1011101100220011', 'cvcCode' => '']];

        yield 'невалидный cvcCode' => [['cardNumber' => '1011101100220011', 'cvcCode' => 'fake']];
    }
}
