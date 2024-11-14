<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards\MockResponse;

use GuzzleHttp\Psr7\Response;

final class SetCardResponse
{
    public static function getResponse(): Response
    {
        return new Response(
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
    }
}
