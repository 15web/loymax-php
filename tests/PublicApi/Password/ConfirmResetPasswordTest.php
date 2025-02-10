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
#[TestDox('Запрос на отправку введенного кода подтверждения для восстановления пароля')]
final class ConfirmResetPasswordTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSucceed(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "token_type": "Bearer",
                    "access_token": "accessToken",
                    "refresh_token": "refreshToken",
                    "expires_in": 86400
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
            ->confirmResetPassword(
                notifierIdentity: '7900000001',
                confirmCode: '123456',
                newPassword: 'newPassword',
            );

        self::assertSame('accessToken', $result->accessToken);
        self::assertSame('refreshToken', $result->refreshToken);
        self::assertSame('Bearer', $result->tokenType);
        self::assertSame(86400, $result->expiresIn);
    }

    #[TestDox('Запрос завершился с ошибкой')]
    public function testFailed(): void
    {
        $this->expectException(InvalidResponse::class);
        $this->expectExceptionMessage('Проверьте правильность введенных данных. Осталось 11 попыток.');

        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "result": {
                    "state": "Error",
                    "httpCode": 400,
                    "message": "Проверьте правильность введенных данных. Осталось 11 попыток.",
                    "messageCode": null,
                    "exception": null,
                    "validationErrors": null
                  }
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi()
            ->password()
            ->confirmResetPassword(
                notifierIdentity: '7900000001',
                confirmCode: '123456',
                newPassword: 'newPassword',
            );
    }

    /**
     * @param array{
     *     notifierIdentity: non-empty-string,
     *     confirmCode: non-empty-string,
     *     newPassword: non-empty-string
     * } $data
     */
    #[DataProvider('invalidStartResetPasswordRequestDataProvider')]
    #[TestDox('Невалидные данные в запросе')]
    public function testInvalidRequestData(array $data): void
    {
        $this->expectException(InvalidArgumentException::class);

        $loymax = $this->createLoymaxClient();

        $loymax->publicApi()
            ->password()
            ->confirmResetPassword(
                notifierIdentity: $data['notifierIdentity'],
                confirmCode: $data['confirmCode'],
                newPassword: $data['newPassword'],
            );
    }

    public static function invalidStartResetPasswordRequestDataProvider(): Iterator
    {
        yield 'пустой запрос' => [['notifierIdentity' => '', 'confirmCode' => '', 'newPassword' => '']];

        yield 'пустой notifierIdentity' => [['notifierIdentity' => '', 'confirmCode' => '123456', 'newPassword' => 'newPassword']];

        yield 'пустой confirmCode' => [['notifierIdentity' => '79000000001', 'confirmCode' => '', 'newPassword' => 'newPassword']];

        yield 'пустой newPassword' => [['notifierIdentity' => '79000000001', 'confirmCode' => '123456', 'newPassword' => '']];
    }
}
