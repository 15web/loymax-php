<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\Cards;

use DateTimeImmutable;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Data\HttpStatusCode;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\PublicApi\Cards\Response\CardState;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Возвращает список карт текущего клиента и все операции по ним')]
final class GetCardsTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSuccess(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data":  [
                    {
                      "id": 1,
                      "state": "Emitted",
                      "number": "2002-3002-4002-5002",
                      "barCode": "1234567890",
                      "block": false,
                      "expiryDate": "2024-03-25T12:18:27.180Z",
                      "cardCategory": {
                        "id": 1,
                        "title": "Virtual",
                        "logicalName": "Virtual Card",
                        "images": [
                          {
                            "fileId": "018e758c-fc50-7231-83d5-bbf2db3b69ec",
                            "description": "My first Card"
                          }
                        ]
                      },
                      "cardOwnerInfo": {
                        "id": 1,
                        "personUid": "018e758d-1429-718b-8282-08b751862670",
                        "firstName": "First",
                        "lastName": "Last",
                        "patronymicName": "Patron",
                        "phoneNumber": "***1234",
                        "email": "client@example.com"
                      },
                      "accumulated": {
                        "amount": 300.0,
                        "currency": "RUB",
                        "currencyInfo": {
                          "id": 1,
                          "name": "Rubles",
                          "code": "RUB",
                          "uid": "018e758f-7abc-7bb9-a035-3f3a42e6d7a4",
                          "externalId": "0100",
                          "imageId": "018e758d-28f2-7397-a963-c3b10ecc7cc4",
                          "description": "Rubles",
                          "isDeleted": false,
                          "nameCases": {
                            "nominative": "rub",
                            "genitive": "rub",
                            "plural": "rub",
                            "abbreviation": "rub"
                          }
                        }
                      },
                      "paid": {
                        "amount": 200.0,
                        "currency": "RUB",
                        "currencyInfo": {
                          "id": 1,
                          "name": "Rubles",
                          "code": "RUB",
                          "uid": "018e758f-7abc-7bb9-a035-3f3a42e6d7a4",
                          "externalId": "0100",
                          "imageId": "018e758d-28f2-7397-a963-c3b10ecc7cc4",
                          "description": "Rubles",
                          "isDeleted": false,
                          "nameCases": {
                            "nominative": "rub",
                            "genitive": "rub",
                            "plural": "rub",
                            "abbreviation": "rub"
                          }
                        }
                      },
                      "accumulatedInfo": [
                        {
                          "amount": 300.0,
                          "currency": "RUB",
                          "currencyInfo": {
                            "id": 1,
                            "name": "Rubles",
                            "code": "RUB",
                            "uid": "018e758f-7abc-7bb9-a035-3f3a42e6d7a4",
                            "externalId": "0100",
                            "imageId": "018e758d-28f2-7397-a963-c3b10ecc7cc4",
                            "description": "Rubles",
                            "isDeleted": false,
                            "nameCases": {
                              "nominative": "rub",
                              "genitive": "rub",
                              "plural": "rub",
                              "abbreviation": "rub"
                            }
                          }
                        }
                      ],
                      "paidInfo": [
                        {
                          "amount": 200.0,
                          "currency": "RUB",
                          "currencyInfo": {
                            "id": 1,
                            "name": "Rubles",
                            "code": "RUB",
                            "uid": "018e758f-7abc-7bb9-a035-3f3a42e6d7a4",
                            "externalId": "0100",
                            "imageId": "018e758d-28f2-7397-a963-c3b10ecc7cc4",
                            "description": "Rubles",
                            "isDeleted": false,
                            "nameCases": {
                              "nominative": "rub",
                              "genitive": "rub",
                              "plural": "rub",
                              "abbreviation": "rub"
                            }
                          }
                        }
                      ],
                      "cardActionAccessInfo": {
                        "canBlock": true,
                        "canReplace": true
                      }
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
                JSON
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $result = $loymax->publicApi()->cards()->getCards();

        /** @var non-empty-string $expiryDate */
        $expiryDate = $result[0]->expiryDate;

        self::assertCount(1, $result);
        self::assertSame(1, $result[0]->id);
        self::assertSame(CardState::Emitted->value, $result[0]->state->value);
        self::assertSame('2002-3002-4002-5002', $result[0]->number);
        self::assertSame('1234567890', $result[0]->barCode);
        self::assertFalse($result[0]->block);
        self::assertSame('2024-03-25T12:18:27Z', (new DateTimeImmutable($expiryDate))->format('Y-m-d\TH:i:sp'));
        self::assertSame(1, $result[0]->cardCategory->id);
        self::assertSame('Virtual', $result[0]->cardCategory->title);
        self::assertSame('Virtual Card', $result[0]->cardCategory->logicalName);

        self::assertSame(300.0, $result[0]->accumulated->amount);
        self::assertSame(1, $result[0]->accumulated->currencyInfo->id);
        self::assertSame('Rubles', $result[0]->accumulated->currencyInfo->name);
        self::assertSame('RUB', $result[0]->accumulated->currencyInfo->code);
        self::assertCount(1, $result[0]->accumulatedInfo);
        self::assertSame(300.0, $result[0]->accumulatedInfo[0]->amount);
        self::assertSame(1, $result[0]->accumulatedInfo[0]->currencyInfo->id);
        self::assertSame('Rubles', $result[0]->accumulatedInfo[0]->currencyInfo->name);
        self::assertSame('RUB', $result[0]->accumulatedInfo[0]->currencyInfo->code);

        self::assertSame(200.0, $result[0]->paid->amount);
        self::assertSame(1, $result[0]->paid->currencyInfo->id);
        self::assertSame('Rubles', $result[0]->paid->currencyInfo->name);
        self::assertSame('RUB', $result[0]->paid->currencyInfo->code);
        self::assertCount(1, $result[0]->paidInfo);
        self::assertSame(200.0, $result[0]->paidInfo[0]->amount);
        self::assertSame(1, $result[0]->paidInfo[0]->currencyInfo->id);
        self::assertSame('Rubles', $result[0]->paidInfo[0]->currencyInfo->name);
        self::assertSame('RUB', $result[0]->paidInfo[0]->currencyInfo->code);

        self::assertTrue($result[0]->cardActionAccessInfo->canBlock);
        self::assertTrue($result[0]->cardActionAccessInfo->canReplace);
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
                JSON
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $result = $loymax->publicApi()->cards()->getCards();

        self::assertSame([], $result);
    }

    #[TestDox('Неавторизованный запрос')]
    public function testUnauthorized(): void
    {
        $this->expectException(Unauthorized::class);

        $mockResponse = new Response(
            status: HttpStatusCode::HTTP_UNAUTHORIZED->value,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi()->cards()->getCards();
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
        $loymax->publicApi()->cards()->getCards();
    }
}
