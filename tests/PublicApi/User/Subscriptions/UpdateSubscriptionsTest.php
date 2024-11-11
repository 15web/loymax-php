<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\User\Subscriptions;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\PublicApi\User\Response\UpdatedSubscription;
use Studio15\Loymax\PublicApi\User\Response\UpdatedSubscriptionChannel;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Обновление информации о подписках клиента')]
final class UpdateSubscriptionsTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSuccess(): void
    {
        $this->expectNotToPerformAssertions();

        $mockResponse = new Response(
            body: <<<'JSON'
                {
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

        $request = [
            new UpdatedSubscription(
                typeId: 6,
                smsNotification: new UpdatedSubscriptionChannel(
                    selected: true
                ),
                emailNotification: new UpdatedSubscriptionChannel(
                    selected: false
                ),
            ),
        ];

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi('validAccessToken')->user()->updateSubscriptions($request);
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

        $request = [
            new UpdatedSubscription(
                typeId: 6,
                smsNotification: new UpdatedSubscriptionChannel(
                    selected: true
                ),
                emailNotification: new UpdatedSubscriptionChannel(
                    selected: false
                ),
            ),
        ];

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi()->user()->updateSubscriptions($request);
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

        $request = [
            new UpdatedSubscription(
                typeId: 6,
                smsNotification: new UpdatedSubscriptionChannel(
                    selected: true
                ),
                emailNotification: new UpdatedSubscriptionChannel(
                    selected: false
                ),
            ),
        ];

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi('validAccessToken')->user()->updateSubscriptions($request);
    }
}
