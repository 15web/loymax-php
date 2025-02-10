<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\Password;

use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Запрос на восстановление пароля')]
final class StartResetPasswordTest extends TestCase
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
        $result = $loymax->publicApi()
            ->password()
            ->startResetPassword(
                notifierIdentity: '7900000001',
            );

        self::assertSame(6, $result->codeLength);
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
        $loymax->publicApi()
            ->password()
            ->startResetPassword(
                notifierIdentity: '7900000001',
            );
    }

    /**
     * @param non-empty-string $notifierIdentity
     */
    #[DataProvider('invalidStartResetPasswordRequestDataProvider')]
    #[TestDox('Невалидные данные в запросе')]
    public function testInvalidRequestData(string $notifierIdentity): void
    {
        $this->expectException(InvalidArgumentException::class);

        $loymax = $this->createLoymaxClient();

        $loymax->publicApi()
            ->password()
            ->startResetPassword(
                notifierIdentity: $notifierIdentity,
            );
    }

    public static function invalidStartResetPasswordRequestDataProvider(): Iterator
    {
        yield 'пустой notifierIdentity' => [''];
    }
}
