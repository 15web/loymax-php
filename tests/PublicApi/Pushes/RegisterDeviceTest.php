<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\Pushes;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\PublicApi\Pushes\Request\PlatformType;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Регистрация мобильного устройства')]
final class RegisterDeviceTest extends TestCase
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
                    "message": null,
                    "messageCode": null,
                    "exception": null,
                    "validationErrors": null
                  }
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi('validAccessToken')->pushes()->registerDevice(
            token: 'fkBQTHxKKhs:AP91bHuEedxM4xFAUn0z',
            platformType: PlatformType::Android,
            userAgent: 'Loymax-Mobile-dev.test.playground/1.1.5959 (Android/28; ANE-LX1)',
            deviceId: '80937947-2C04-4BB0-8E33-7CF6031A2333',
            platformVersion: '14',
        );
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
        $loymax->publicApi('invalidAccessToken')->pushes()->registerDevice(
            token: 'fkBQTHxKKhs:AP91bHuEedxM4xFAUn0z',
            platformType: PlatformType::Android,
            userAgent: 'Loymax-Mobile-dev.test.playground/1.1.5959 (Android/28; ANE-LX1)',
            deviceId: '80937947-2C04-4BB0-8E33-7CF6031A2333',
            platformVersion: '14',
        );
    }

    #[TestDox('Устройство не является мобильным телефоном')]
    public function testNonMobileDevice(): void
    {
        $this->expectException(InvalidResponse::class);
        $this->expectExceptionMessage('Метод доступен только для мобильных устройств');

        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {},
                  "result": {
                    "state": "Error",
                    "httpCode": 400,
                    "message": "Метод доступен только для мобильных устройств",
                    "messageCode": "Business.Base",
                    "exception": "InvalidRequest",
                    "validationErrors": []
                  }
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi('invalidAccessToken')->pushes()->registerDevice(
            token: 'fkBQTHxKKhs:AP91bHuEedxM4xFAUn0z',
            platformType: PlatformType::Android,
            userAgent: 'Loymax-Mobile-dev.test.playground/1.1.5959 (Android/28; ANE-LX1)',
            deviceId: 'invalidDeviceId',
            platformVersion: '14',
        );
    }

    #[TestDox('Запрос завершился с ошибкой')]
    public function testError(): void
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

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi('invalidAccessToken')->pushes()->registerDevice(
            token: 'fkBQTHxKKhs:AP91bHuEedxM4xFAUn0z',
            platformType: PlatformType::Android,
            userAgent: 'Loymax-Mobile-dev.test.playground/1.1.5959 (Android/28; ANE-LX1)',
            deviceId: '80937947-2C04-4BB0-8E33-7CF6031A2333',
            platformVersion: '14',
        );
    }

    #[TestDox('Системная ошибка процессинга')]
    public function testFailed(): void
    {
        $this->expectException(InvalidResponse::class);
        $this->expectExceptionMessage('Идентификатор ошибки: 1ead0d20c2e54fe3969a5c2291775ead');

        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {},
                  "result": {
                    "state": "Fail",
                    "httpCode": 400,
                    "message": "Идентификатор ошибки: 1ead0d20c2e54fe3969a5c2291775ead",
                    "messageCode": "Business.Base",
                    "exception": "InvalidRequest",
                    "validationErrors": []
                  }
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi('invalidAccessToken')->pushes()->registerDevice(
            token: 'fkBQTHxKKhs:AP91bHuEedxM4xFAUn0z',
            platformType: PlatformType::Android,
            userAgent: 'Loymax-Mobile-dev.test.playground/1.1.5959 (Android/28; ANE-LX1)',
            deviceId: '80937947-2C04-4BB0-8E33-7CF6031A2333',
            platformVersion: '14',
        );
    }
}
