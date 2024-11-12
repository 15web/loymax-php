<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\User;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\PublicApi\User\Response\RegistrationActionState;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Получение списка необходимых шагов регистрации')]
final class GetRegistrationActionsTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSucceed(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "actions": [
                      {
                        "userActionType": "AcceptTenderOffer",
                        "actionState": "Required",
                        "isDone": true
                      },
                      {
                        "userActionType": "AcceptSubscriptionsConfirm",
                        "actionState": "Custom",
                        "isDone": false
                      }
                    ]
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
        $result = $loymax->publicApi('validAccessToken')->user()->getRegistrationActions();

        self::assertCount(2, $result->actions);

        self::assertSame('AcceptTenderOffer', $result->actions[0]->userActionType);
        self::assertSame(RegistrationActionState::REQUIRED, $result->actions[0]->actionState);
        self::assertTrue($result->actions[0]->isDone);

        self::assertSame('AcceptSubscriptionsConfirm', $result->actions[1]->userActionType);
        self::assertSame(RegistrationActionState::CUSTOM, $result->actions[1]->actionState);
        self::assertFalse($result->actions[1]->isDone);

        self::assertFalse($result->isSubscriptionsConfirmed());
    }

    #[TestDox('Подписка подтверждена')]
    public function testSubscriptionsConfirmed(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "actions": [
                      {
                        "userActionType": "AcceptTenderOffer",
                        "actionState": "Required",
                        "isDone": true
                      },
                      {
                        "userActionType": "AcceptSubscriptionsConfirm",
                        "actionState": "Custom",
                        "isDone": true
                      }
                    ]
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
        $result = $loymax->publicApi('validAccessToken')->user()->getRegistrationActions();

        self::assertTrue($result->isSubscriptionsConfirmed());
    }

    #[TestDox('Пустой список шагов')]
    public function testEmptyList(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "actions": []
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
        $result = $loymax->publicApi('validAccessToken')->user()->getRegistrationActions();

        self::assertCount(0, $result->actions);
        self::assertFalse($result->isSubscriptionsConfirmed());
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
        $loymax->publicApi()->user()->getRegistrationActions();
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
        $loymax->publicApi('validAccessToken')->user()->getRegistrationActions();
    }
}
