<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\Registration;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Data\HttpStatusCode;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\PublicApi\Registration\Response\UncompletedAction;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Завершение регистрации клиента')]
final class TryFinishRegistrationTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSuccess(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "registrationCompleted": true,
                    "token_type": "Bearer",
                    "access_token": "accessToken",
                    "refresh_token": "refreshToken",
                    "expires_in": 86400,
                    "uncompletedActions": null
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
        $result = $loymax->publicApi('validAccessToken')->registration()->tryFinishRegistration();

        self::assertTrue($result->registrationCompleted);
        self::assertSame('Bearer', $result->tokenType);
        self::assertSame('accessToken', $result->accessToken);
        self::assertSame('refreshToken', $result->refreshToken);
        self::assertSame(86400, $result->expiresIn);
    }

    #[TestDox('Регистрация не завершены из-за невыполненных действий')]
    public function testUncompletedActions(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "registrationCompleted": false,
                    "token_type": "Bearer",
                    "access_token": "accessToken",
                    "refresh_token": "refreshToken",
                    "expires_in": 86400,
                    "uncompletedActions": [
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
        $result = $loymax->publicApi('validAccessToken')->registration()->tryFinishRegistration();

        self::assertFalse($result->registrationCompleted);
        self::assertSame('Bearer', $result->tokenType);
        self::assertSame('accessToken', $result->accessToken);
        self::assertSame('refreshToken', $result->refreshToken);
        self::assertSame(86400, $result->expiresIn);

        /** @var list<UncompletedAction> $uncompletedActions */
        $uncompletedActions = $result->uncompletedActions;

        self::assertCount(2, $uncompletedActions);
        self::assertSame('AcceptTenderOffer', $uncompletedActions[0]->userActionType);
        self::assertSame('Required', $uncompletedActions[0]->actionState);
        self::assertTrue($uncompletedActions[0]->isDone);
        self::assertSame('AcceptSubscriptionsConfirm', $uncompletedActions[1]->userActionType);
        self::assertSame('Custom', $uncompletedActions[1]->actionState);
        self::assertFalse($uncompletedActions[1]->isDone);
    }

    #[TestDox('Неавторизованный запрос')]
    public function testUnauthorized(): void
    {
        $this->expectException(Unauthorized::class);

        $mockResponse = new Response(
            status: HttpStatusCode::HTTP_UNAUTHORIZED->value,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi('invalidAccessToken')->registration()->tryFinishRegistration();
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
        $loymax->publicApi('invalidAccessToken')->registration()->tryFinishRegistration();
    }
}
