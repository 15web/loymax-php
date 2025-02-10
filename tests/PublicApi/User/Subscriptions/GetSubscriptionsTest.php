<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\User\Subscriptions;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\PublicApi\User\Response\SubscriptionExternalId;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Получение информации о подписках')]
final class GetSubscriptionsTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSuccess(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                    "data": [
                        {
                            "typeId": 6,
                            "typeName": "Рассылки",
                            "externalId": "Advertisement",
                            "smsNotification": {
                                "readOnly": false,
                                "selected": true
                            },
                            "emailNotification": {
                                "readOnly": false,
                                "selected": true
                            },
                            "pushNotification": {
                                "readOnly": false,
                                "selected": true
                            },
                            "viberNotification": {
                                "readOnly": false,
                                "selected": true
                            },
                            "socialNetworksNotification": {
                                "readOnly": false,
                                "selected": true
                            },
                            "chatBotNotification": {
                                "readOnly": false,
                                "selected": true
                            }
                        },
                        {
                            "typeId": 5,
                            "typeName": "Системная информация",
                            "externalId": "System",
                            "smsNotification": {
                                "readOnly": true,
                                "selected": true
                            },
                            "emailNotification": {
                                "readOnly": true,
                                "selected": true
                            },
                            "pushNotification": {
                                "readOnly": true,
                                "selected": true
                            },
                            "viberNotification": {
                                "readOnly": true,
                                "selected": true
                            },
                            "socialNetworksNotification": {
                                "readOnly": false,
                                "selected": false
                            },
                            "chatBotNotification": {
                                "readOnly": false,
                                "selected": false
                            }
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

        $request = [
            SubscriptionExternalId::Advertisement,
            SubscriptionExternalId::System,
        ];

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $result = $loymax->publicApi('validAccessToken')->user()->getSubscriptions($request);

        self::assertCount(2, $result);

        self::assertSame(6, $result[0]->typeId);
        self::assertSame('Рассылки', $result[0]->typeName);
        self::assertSame(SubscriptionExternalId::Advertisement, $result[0]->externalId);

        self::assertFalse($result[0]->smsNotification->readOnly);
        self::assertTrue($result[0]->smsNotification->selected);

        self::assertFalse($result[0]->emailNotification->readOnly);
        self::assertTrue($result[0]->emailNotification->selected);

        self::assertFalse($result[0]->pushNotification->readOnly);
        self::assertTrue($result[0]->pushNotification->selected);

        self::assertFalse($result[0]->viberNotification->readOnly);
        self::assertTrue($result[0]->viberNotification->selected);

        self::assertFalse($result[0]->socialNetworksNotification->readOnly);
        self::assertTrue($result[0]->socialNetworksNotification->selected);

        self::assertFalse($result[0]->chatBotNotification->readOnly);
        self::assertTrue($result[0]->chatBotNotification->selected);

        self::assertSame(5, $result[1]->typeId);
        self::assertSame('Системная информация', $result[1]->typeName);
        self::assertSame(SubscriptionExternalId::System, $result[1]->externalId);

        self::assertTrue($result[1]->smsNotification->readOnly);
        self::assertTrue($result[1]->smsNotification->selected);

        self::assertTrue($result[1]->emailNotification->readOnly);
        self::assertTrue($result[1]->emailNotification->selected);

        self::assertTrue($result[1]->pushNotification->readOnly);
        self::assertTrue($result[1]->pushNotification->selected);

        self::assertTrue($result[1]->viberNotification->readOnly);
        self::assertTrue($result[1]->viberNotification->selected);

        self::assertFalse($result[1]->socialNetworksNotification->readOnly);
        self::assertFalse($result[1]->socialNetworksNotification->selected);

        self::assertFalse($result[1]->chatBotNotification->readOnly);
        self::assertFalse($result[1]->chatBotNotification->selected);
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

        $request = [
            SubscriptionExternalId::Advertisement,
            SubscriptionExternalId::System,
        ];

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $result = $loymax->publicApi('validAccessToken')->user()->getSubscriptions($request);

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

        $request = [
            SubscriptionExternalId::Advertisement,
            SubscriptionExternalId::System,
        ];

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi()->user()->getSubscriptions($request);
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

        $request = [
            SubscriptionExternalId::Advertisement,
            SubscriptionExternalId::System,
        ];

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi('validAccessToken')->user()->getSubscriptions($request);
    }
}
