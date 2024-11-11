<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\User;

use DateTimeImmutable;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\PublicApi\User\Request\GetUserPayload;
use Studio15\Loymax\PublicApi\User\Response\BalanceShortInfo;
use Studio15\Loymax\PublicApi\User\Response\UserState;
use Studio15\Loymax\Test\TestCase;
use Webmozart\Assert\InvalidArgumentException;

/**
 * @internal
 */
#[TestDox('Получение информации о текущем авторизованном клиенте')]
final class GetUserTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSuccess(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "id": 1,
                    "personUid": "018e758f-7abc-7bb9-a035-3f3a42e6d7a4",
                    "firstName": "First",
                    "lastName": "Last",
                    "patronymicName": "Patron",
                    "birthDay": "2024-03-25T12:35:41.968Z",
                    "state": "Normal",
                    "addressInfo": {
                      "city": "Moscow",
                      "street": "Tverskaya",
                      "house": "25",
                      "building": "A",
                      "flat": "7"
                    },
                    "cardShortInfo": {
                      "id": 1,
                      "balance": 100,
                      "isBlocked": false,
                      "number": "2002-3002-4002-5002"
                    },
                    "balanceShortInfo": null,
                    "cards": null,
                    "phoneNumber": "***1234",
                    "email": "market@example.com",
                    "balanceDetailedInfo": null,
                    "emailDetailedInfo": null
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
        $result = $loymax->publicApi('validAccessToken')->user()->getUser();

        /** @var non-empty-string $firstName */
        $firstName = $result->firstName;

        /** @var non-empty-string $lastName */
        $lastName = $result->lastName;

        /** @var non-empty-string $patronymicName */
        $patronymicName = $result->patronymicName;

        /** @var non-empty-string $birthday */
        $birthday = $result->birthDay;

        /** @var non-empty-string $phoneNumber */
        $phoneNumber = $result->phoneNumber;

        /** @var non-empty-string $email */
        $email = $result->email;

        self::assertSame(1, $result->id);
        self::assertSame('018e758f-7abc-7bb9-a035-3f3a42e6d7a4', $result->personUid);
        self::assertSame('First', $firstName);
        self::assertSame('Last', $lastName);
        self::assertSame('Patron', $patronymicName);
        self::assertSame('2024-03-25T12:35:41Z', (new DateTimeImmutable($birthday))->format('Y-m-d\TH:i:sp'));
        self::assertSame(UserState::Normal->value, $result->state->value);
        self::assertSame('***1234', $phoneNumber);
        self::assertSame('market@example.com', $email);
        self::assertNull($result->balanceShortInfo);
        self::assertNull($result->getAttributeValue('city'));
    }

    #[TestDox('Получение атрибутов клиента')]
    public function testGetAttributes(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                    "data": {
                        "firstName": null,
                        "lastName": null,
                        "patronymicName": null,
                        "birthDay": null,
                        "state": "Normal",
                        "addressInfo": null,
                        "cardShortInfo": null,
                        "balanceShortInfo": null,
                        "attributes": {
                            "phone": {
                                "$type": "Loymax.Common.Contract.Model.UserInfo.StringValueModel, Loymax.Common.Contract",
                                "stringValue": "79991234567"
                            },
                            "sex": {
                                "$type": "Loymax.Common.Contract.Model.UserInfo.FixedAnswersModel, Loymax.Common.Contract",
                                "answers": [
                                    "Мужской"
                                ]
                            }
                        },
                        "cards": null,
                        "phoneNumber": null,
                        "email": null,
                        "balanceDetailedInfo": null,
                        "emailDetailedInfo": null,
                        "id": 10524,
                        "personUid": "9f59a1ea-a9e6-4717-9618-156dad956520"
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
        $result = $loymax->publicApi('validAccessToken')->user()->getUser([
            'Attributes.phone',
            'Attributes.sex',
        ]);

        self::assertSame('79991234567', $result->getAttributeValue('phone'));
        self::assertSame('Мужской', $result->getAttributeValue('sex'));
        self::assertNull($result->getAttributeValue('city'));
    }

    #[TestDox('Запрос информации о балансе')]
    public function testBalanceShortInfo(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "id": 1,
                    "personUid": "018e758f-7abc-7bb9-a035-3f3a42e6d7a4",
                    "firstName": null,
                    "lastName": null,
                    "patronymicName": null,
                    "birthDay": null,
                    "state": "Normal",
                    "addressInfo": null,
                    "cardShortInfo": null,
                    "balanceShortInfo": {
                      "balance": {
                        "amount": 100.0,
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
                      "notActivated": {
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
                      "accumulated": {
                        "amount": 700.0,
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
                        "amount": 400.0,
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
                    },
                    "cards": null,
                    "phoneNumber": null,
                    "email": null,
                    "balanceDetailedInfo": null,
                    "emailDetailedInfo": null
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
        $result = $loymax->publicApi('validAccessToken')->user()->getUser([
            GetUserPayload::BalanceShortInfo,
        ]);

        /** @var BalanceShortInfo $balanceShortInfo */
        $balanceShortInfo = $result->balanceShortInfo;

        self::assertSame(1, $result->id);
        self::assertSame('018e758f-7abc-7bb9-a035-3f3a42e6d7a4', $result->personUid);
        self::assertNull($result->firstName);
        self::assertNull($result->lastName);
        self::assertNull($result->patronymicName);
        self::assertNull($result->birthDay);
        self::assertSame(UserState::Normal->value, $result->state->value);
        self::assertNull($result->phoneNumber);
        self::assertNull($result->email);
        self::assertSame(100.0, $balanceShortInfo->balance->amount);
        self::assertSame('RUB', $balanceShortInfo->balance->currency);
        self::assertSame(200.0, $balanceShortInfo->notActivated->amount);
        self::assertSame('RUB', $balanceShortInfo->notActivated->currency);
        self::assertSame(700.0, $balanceShortInfo->accumulated->amount);
        self::assertSame('RUB', $balanceShortInfo->accumulated->currency);
        self::assertSame(400.0, $balanceShortInfo->paid->amount);
        self::assertSame('RUB', $balanceShortInfo->paid->currency);
    }

    #[TestDox('Некорректный запрос')]
    public function testInvalidArgument(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $loymax = $this->createLoymaxClient();
        $loymax->publicApi()->user()->getUser([
            'invalidArgument',
        ]);
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
        $loymax->publicApi()->user()->getUser();
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
        $loymax->publicApi('validAccessToken')->user()->getUser();
    }
}
