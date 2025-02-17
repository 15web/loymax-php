<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\User\Phone;

use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\Test\TestCase;

/** @internal */
#[TestDox('Смена номера телефона')]
final class ChangePhoneNumberTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSucceed(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "codeLength": 6
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
        $result = $loymax->publicApi('validAccessToken')
            ->user()
            ->changePhoneNumber('79999999999');

        self::assertSame(6, $result->codeLength);
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
        $loymax->publicApi()
            ->user()
            ->changePhoneNumber('79999999999');
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
        $loymax->publicApi('validAccessToken')
            ->user()
            ->changePhoneNumber('79999999999');
    }

    /**
     * @param numeric-string $invalidPhoneNumber
     */
    #[TestDox('Невалидный номер телефона')]
    #[DataProvider('invalidChangePhoneNumberRequestProvider')]
    public function testInvalidPhoneNumber(string $invalidPhoneNumber): void
    {
        $this->expectException(InvalidArgumentException::class);

        $loymax = $this->createLoymaxClient();
        $loymax->publicApi('validAccessToken')
            ->user()
            ->changePhoneNumber($invalidPhoneNumber);
    }

    public static function invalidChangePhoneNumberRequestProvider(): Iterator
    {
        yield 'пустая строка' => [''];

        yield 'текст' => ['любая строка'];

        yield 'невалидный номер' => ['+7999-000-11111'];
    }
}
