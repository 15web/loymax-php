<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\Cards;

use DateTimeImmutable;
use DateTimeInterface;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Получение списка карт текущего клиента и все операции по ним')]
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
                      "$type": "Loymax.Mobile.Contract.Models.Cards.VirtualCardInfo, Loymax.Mobile.Contract",
                      "qrContent": "https://loymax.ru/join/0123456789",
                      "accumulated": {
                        "amount": 100.0,
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
                        "amount": 50.0,
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
                          "amount": 100.0000,
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
                          "amount": 50.0000,
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
                        "images": [
                          {
                            "fileId": "01932720-f3e2-786d-a9d5-80ed576fd102",
                            "description": "Изображение"
                          }
                        ]
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
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $result = $loymax->publicApi()->cards()->getCards();

        /** @var DateTimeImmutable $expiryDate */
        $expiryDate = $result[0]->expiryDate;

        self::assertCount(1, $result);
        self::assertSame(456, $result[0]->id);
        self::assertSame('https://loymax.ru/join/0123456789', $result[0]->qrContent);
        self::assertSame('Activated', $result[0]->state->value);
        self::assertSame('1011101100220011', $result[0]->number);
        self::assertSame('1011101100220011', $result[0]->barCode);
        self::assertFalse($result[0]->block);
        self::assertSame('2024-03-25T12:18:27+00:00', $expiryDate->format(DateTimeInterface::ATOM));
        self::assertSame(1, $result[0]->cardCategory->id);
        self::assertSame('Виртуальная карта', $result[0]->cardCategory->title);
        self::assertNull($result[0]->cardCategory->description);
        self::assertSame(0, $result[0]->cardCategory->cardCount);
        self::assertSame('VirtualCard', $result[0]->cardCategory->logicalName);

        self::assertCount(1, $result[0]->cardCategory->images);
        self::assertSame('01932720-f3e2-786d-a9d5-80ed576fd102', (string) $result[0]->cardCategory->images[0]->fileId);
        self::assertSame('Изображение', $result[0]->cardCategory->images[0]->description);

        self::assertSame(100.0, $result[0]->accumulated->amount);
        self::assertSame('бнс.', $result[0]->accumulated->currency);
        self::assertSame(1, $result[0]->accumulated->currencyInfo->id);
        self::assertSame('Бонусы', $result[0]->accumulated->currencyInfo->name);
        self::assertSame('Currency1', $result[0]->accumulated->currencyInfo->code);
        self::assertSame('0193260a-8040-7d4c-a916-0fbbad2a3e0d', (string) $result[0]->accumulated->currencyInfo->uid);
        self::assertSame('0193260a-8040-7d4c-a916-0fbbad2a3e0d', (string) $result[0]->accumulated->currencyInfo->externalId);
        self::assertNull($result[0]->accumulated->currencyInfo->imageId);
        self::assertSame('Общая внутрисистемная валюта', $result[0]->accumulated->currencyInfo->description);
        self::assertFalse($result[0]->accumulated->currencyInfo->isDeleted);
        self::assertSame('бонус', $result[0]->accumulated->currencyInfo->nameCases->nominative);
        self::assertSame('бонуса', $result[0]->accumulated->currencyInfo->nameCases->genitive);
        self::assertSame('бонусов', $result[0]->accumulated->currencyInfo->nameCases->plural);
        self::assertSame('бнс.', $result[0]->accumulated->currencyInfo->nameCases->abbreviation);

        self::assertSame(50.0, $result[0]->paid->amount);
        self::assertSame('бнс.', $result[0]->paid->currency);
        self::assertSame(1, $result[0]->paid->currencyInfo->id);
        self::assertSame('Бонусы', $result[0]->paid->currencyInfo->name);
        self::assertSame('Currency1', $result[0]->paid->currencyInfo->code);
        self::assertSame('0193260a-8040-7d4c-a916-0fbbad2a3e0d', (string) $result[0]->paid->currencyInfo->uid);
        self::assertSame('0193260a-8040-7d4c-a916-0fbbad2a3e0d', (string) $result[0]->paid->currencyInfo->externalId);
        self::assertNull($result[0]->paid->currencyInfo->imageId);
        self::assertSame('Общая внутрисистемная валюта', $result[0]->paid->currencyInfo->description);
        self::assertFalse($result[0]->paid->currencyInfo->isDeleted);
        self::assertSame('бонус', $result[0]->paid->currencyInfo->nameCases->nominative);
        self::assertSame('бонуса', $result[0]->paid->currencyInfo->nameCases->genitive);
        self::assertSame('бонусов', $result[0]->paid->currencyInfo->nameCases->plural);
        self::assertSame('бнс.', $result[0]->paid->currencyInfo->nameCases->abbreviation);

        self::assertCount(1, $result[0]->accumulatedInfo);
        self::assertSame(100.0, $result[0]->accumulatedInfo[0]->amount);
        self::assertSame('Прив.бнс.', $result[0]->accumulatedInfo[0]->currency);
        self::assertSame(4, $result[0]->accumulatedInfo[0]->currencyInfo->id);
        self::assertSame('Приветственные бонусы', $result[0]->accumulatedInfo[0]->currencyInfo->name);
        self::assertSame('Currency3', $result[0]->accumulatedInfo[0]->currencyInfo->code);
        self::assertSame('01932613-26ab-7ca1-8438-f3eba0a8443e', (string) $result[0]->accumulatedInfo[0]->currencyInfo->uid);
        self::assertSame('01932613-26ab-7ca1-8438-f3eba0a8443e', (string) $result[0]->accumulatedInfo[0]->currencyInfo->externalId);
        self::assertNull($result[0]->accumulatedInfo[0]->currencyInfo->imageId);
        self::assertSame('Приветственные бонусы', $result[0]->accumulatedInfo[0]->currencyInfo->description);
        self::assertFalse($result[0]->accumulatedInfo[0]->currencyInfo->isDeleted);
        self::assertSame('Приветственные бонусы', $result[0]->accumulatedInfo[0]->currencyInfo->nameCases->nominative);
        self::assertSame('Приветственного бонуса', $result[0]->accumulatedInfo[0]->currencyInfo->nameCases->genitive);
        self::assertSame('Приветственных бонусов', $result[0]->accumulatedInfo[0]->currencyInfo->nameCases->plural);
        self::assertSame('Прив.бнс.', $result[0]->accumulatedInfo[0]->currencyInfo->nameCases->abbreviation);

        self::assertCount(1, $result[0]->paidInfo);
        self::assertSame(50.0, $result[0]->paidInfo[0]->amount);
        self::assertSame('Прив.бнс.', $result[0]->paidInfo[0]->currency);
        self::assertSame(4, $result[0]->paidInfo[0]->currencyInfo->id);
        self::assertSame('Приветственные бонусы', $result[0]->paidInfo[0]->currencyInfo->name);
        self::assertSame('Currency3', $result[0]->paidInfo[0]->currencyInfo->code);
        self::assertSame('01932613-26ab-7ca1-8438-f3eba0a8443e', (string) $result[0]->paidInfo[0]->currencyInfo->uid);
        self::assertSame('01932613-26ab-7ca1-8438-f3eba0a8443e', (string) $result[0]->paidInfo[0]->currencyInfo->externalId);
        self::assertNull($result[0]->paidInfo[0]->currencyInfo->imageId);
        self::assertSame('Приветственные бонусы', $result[0]->paidInfo[0]->currencyInfo->description);
        self::assertFalse($result[0]->paidInfo[0]->currencyInfo->isDeleted);
        self::assertSame('Приветственные бонусы', $result[0]->paidInfo[0]->currencyInfo->nameCases->nominative);
        self::assertSame('Приветственного бонуса', $result[0]->paidInfo[0]->currencyInfo->nameCases->genitive);
        self::assertSame('Приветственных бонусов', $result[0]->paidInfo[0]->currencyInfo->nameCases->plural);
        self::assertSame('Прив.бнс.', $result[0]->paidInfo[0]->currencyInfo->nameCases->abbreviation);

        self::assertSame(123, $result[0]->cardOwnerInfo->id);
        self::assertSame('01932613-68ab-75cb-8c2f-7e8db1a1182d', (string) $result[0]->cardOwnerInfo->personUid);
        self::assertSame('***5055', $result[0]->cardOwnerInfo->phoneNumber);
        self::assertNull($result[0]->cardOwnerInfo->email);
        self::assertSame('Ivan', $result[0]->cardOwnerInfo->firstName);
        self::assertSame('Ivanov', $result[0]->cardOwnerInfo->lastName);
        self::assertNull($result[0]->cardOwnerInfo->patronymicName);

        self::assertTrue($result[0]->cardActionAccessInfo->canBlock);
        self::assertFalse($result[0]->cardActionAccessInfo->canReplace);
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
        $result = $loymax->publicApi()->cards()->getCards();

        self::assertSame([], $result);
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
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi()->cards()->getCards();
    }
}
