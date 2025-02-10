<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\Registration;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\Authorization\Response\AccessTokenData;
use Studio15\Loymax\PublicApi\Registration\Exception\RegistrationAlreadyCompleted;
use Studio15\Loymax\PublicApi\Registration\Exception\RegistrationBlocked;
use Studio15\Loymax\PublicApi\Registration\Response\BeginRegistrationResponse;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Запуск регистрации клиента')]
final class BeginRegistrationTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSuccess(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "state": "Success",
                    "errorMessage": null,
                    "authToken": "authToken",
                    "authResult": {
                      "token_type": "Bearer",
                      "access_token": "accessToken",
                      "refresh_token": "refreshToken",
                      "expires_in": 86400
                    },
                    "personId": 1
                  },
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
        $result = $loymax->publicApi()->registration()->beginRegistration(
            login: '79990001111',
        );

        /** @var AccessTokenData $authResult */
        $authResult = $result->authResult;

        self::assertSame('Success', $result->state);
        self::assertNull($result->errorMessage);
        self::assertSame('authToken', $result->authToken);
        self::assertSame('Bearer', $authResult->tokenType);
        self::assertSame('accessToken', $authResult->accessToken);
        self::assertSame('refreshToken', $authResult->refreshToken);
        self::assertSame(86400, $authResult->expiresIn);
        self::assertSame(1, $result->personId);
    }

    #[TestDox('Пользователь уже зарегистрирован')]
    public function testRegistrationAlreadyCompleted(): void
    {
        $this->expectException(RegistrationAlreadyCompleted::class);
        $this->expectExceptionMessage('На номер 79990001111 отправлено SMS-сообщение');

        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "personId": null,
                    "state": "RegistrationAlreadyCompleted",
                    "errorMessage": "На номер 79990001111 отправлено SMS-сообщение",
                    "authToken": null,
                    "authResult": null
                  },
                  "result": {
                    "state": "Error",
                    "httpCode": 400,
                    "message": "На номер 79990001111 отправлено SMS-сообщение",
                    "messageCode": null,
                    "exception": null,
                    "validationErrors": null
                  }
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi()->registration()->beginRegistration(
            login: '79990001111',
        );
    }

    #[TestDox('Регистрация заблокирована')]
    public function testRegistrationBlocked(): void
    {
        $this->expectException(RegistrationBlocked::class);
        $this->expectExceptionMessage('На номер 79990001111 отправлено SMS-сообщение');

        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "personId": null,
                    "state": "RegistrationBlocked",
                    "errorMessage": "На номер 79990001111 отправлено SMS-сообщение",
                    "authToken": null,
                    "authResult": null
                  },
                  "result": {
                    "state": "Error",
                    "httpCode": 400,
                    "message": "На номер 79990001111 отправлено SMS-сообщение",
                    "messageCode": null,
                    "exception": null,
                    "validationErrors": null
                  }
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi()->registration()->beginRegistration(
            login: '79990001111',
        );
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
        $loymax->publicApi()->registration()->beginRegistration(
            login: '79990001111',
        );
    }

    #[TestDox('Получение статуса регистрации')]
    public function testBeginRegistrationResponse(): void
    {
        $response = new BeginRegistrationResponse(
            state: 'Success',
            errorMessage: null,
            authToken: 'accessToken',
            authResult: new AccessTokenData(
                accessToken: 'accessToken',
                tokenType: 'Bearer',
                expiresIn: 86400,
                refreshToken: 'refreshToken',
            ),
            personId: 1,
        );

        self::assertFalse($response->isRegistrationBlocked());

        $response = new BeginRegistrationResponse(
            state: 'RegistrationBlocked',
            errorMessage: null,
            authToken: 'accessToken',
            authResult: new AccessTokenData(
                accessToken: 'accessToken',
                tokenType: 'Bearer',
                expiresIn: 86400,
                refreshToken: 'refreshToken',
            ),
            personId: 1,
        );

        self::assertTrue($response->isRegistrationBlocked());
    }
}
