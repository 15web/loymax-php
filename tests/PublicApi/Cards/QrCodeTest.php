<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\Cards;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Генерация QR-кода для карты по ее внутреннему идентификатору')]
final class QrCodeTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSuccess(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data":  {
                    "codeGeneratedDate": "2024-10-29T09:26:48Z",
                    "code": "1001877399942540QR2058410873",
                    "lifeTime": 86400
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
        $result = $loymax->publicApi('validToken')->cards()->qrCode(123);

        self::assertSame('2024-10-29T09:26:48Z', $result->codeGeneratedDate->format('Y-m-d\TH:i:sp'));
        self::assertSame('1001877399942540QR2058410873', $result->code);
        self::assertSame(86400, $result->lifeTime);
    }

    #[TestDox('Не найдена карта')]
    public function testNotFound(): void
    {
        $this->expectException(InvalidResponse::class);
        $this->expectExceptionMessage('Не найдена карта.');

        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "result": {
                    "state": "Error",
                    "httpCode": 400,
                    "message": "Не найдена карта.",
                    "messageCode": "Business.Base",
                    "exception": null,
                    "validationErrors": null
                  }
                }
                JSON
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi('validToken')->cards()->qrCode(999);
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
        $loymax->publicApi('invalidToken')->cards()->qrCode(123);
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
        $loymax->publicApi('validToken')->cards()->qrCode(123);
    }
}
