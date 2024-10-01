<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\User\Phone;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Data\HttpStatusCode;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Запрос на получение информации о подтверждаемом номере телефона')]
final class GetPhoneNumberTest extends TestCase
{
    #[TestDox('Успешный результат, возвращается новый телефон')]
    public function testSuccessNewPhone(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "currentPhoneNumber": "",
                    "newPhoneNumber": {
                      "phoneNumber": "***9999"
                    },
                    "confirmCodeLength": 10
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
        $result = $loymax->publicApi('validAccessToken')->user()->getPhoneNumber();

        self::assertSame('', $result->currentPhoneNumber);
        self::assertSame('***9999', $result->newPhoneNumber?->phoneNumber);
        self::assertSame(10, $result->confirmCodeLength);
    }

    #[TestDox('Успешный результат, возвращается старый(подтвержденный) телефон')]
    public function testSuccessConfirmedPhone(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "currentPhoneNumber": "***9999",
                    "newPhoneNumber": null,
                    "confirmCodeLength": 0
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
        $result = $loymax->publicApi('validAccessToken')->user()->getPhoneNumber();

        self::assertSame('***9999', $result->currentPhoneNumber);
        self::assertNull($result->newPhoneNumber);
        self::assertSame(0, $result->confirmCodeLength);
    }

    #[TestDox('Неавторизованный запрос')]
    public function testUnauthorized(): void
    {
        $this->expectException(Unauthorized::class);

        $mockResponse = new Response(
            status: HttpStatusCode::HTTP_UNAUTHORIZED->value,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi('invalidAccessToken')->user()->getPhoneNumber();
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
                JSON
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi('invalidAccessToken')->user()->getPhoneNumber();
    }
}
