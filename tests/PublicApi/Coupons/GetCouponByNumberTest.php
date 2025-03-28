<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\Coupons;

use DateTimeImmutable;
use DateTimeInterface;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\PublicApi\Coupons\Response\Image;
use Studio15\Loymax\Test\TestCase;
use Symfony\Component\Uid\Uuid;

/**
 * @internal
 */
#[TestDox('Получение информации о купоне по номеру')]
final class GetCouponByNumberTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSucceed(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                    {
                      "data": {
                        "id": 1,
                        "code": "couponCode",
                        "qrContent": "https://example.com/join/couponCode",
                        "createDate": "2024-11-05T12:46:29Z",
                        "updateDate": "2024-11-08T07:21:52Z",
                        "activationDate": "2024-11-08T07:21:52Z",
                        "expiryDate": "2025-11-08T07:21:52Z",
                        "couponState": "Issued",
                        "emissionTitle": "Test Coupon 1",
                        "emissionId": 2,
                        "emissionUid": "01930ac5-0602-7c93-8dbb-123e5eaab990",
                        "shortDescription": "Краткое описание купона",
                        "description": "Полное описание купона",
                        "imageFile": {
                          "fileName": "photo_2023-09-15_14-38-21.png",
                          "fileSize": 34258,
                          "content": "iVBORw0KGgoAAAANSUhEUgAAAL0...by80BPggAAAABJRU5ErkJggg==",
                          "mimeType": "image/png"
                        }
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
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $result = $loymax->publicApi('validToken')->coupons()->getCouponByNumber('couponCode');

        self::assertSame(1, $result->id);
        self::assertSame('couponCode', $result->code);
        self::assertSame(
            (new DateTimeImmutable('2024-11-05T12:46:29Z'))->format(DateTimeInterface::ATOM),
            $result->createDate->format(DateTimeInterface::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2024-11-08T07:21:52Z'))->format(DateTimeInterface::ATOM),
            $result->updateDate->format(DateTimeInterface::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2024-11-08T07:21:52Z'))->format(DateTimeInterface::ATOM),
            $result->activationDate->format(DateTimeInterface::ATOM),
        );

        /** @var DateTimeImmutable $expiryDate */
        $expiryDate = $result->expiryDate;
        self::assertSame(
            (new DateTimeImmutable('2025-11-08T07:21:52Z'))->format(DateTimeInterface::ATOM),
            $expiryDate->format(DateTimeInterface::ATOM),
        );

        self::assertSame('Issued', $result->couponState->value);
        self::assertSame('Test Coupon 1', $result->emissionTitle);
        self::assertSame(2, $result->emissionId);
        self::assertSame(Uuid::fromString('01930ac5-0602-7c93-8dbb-123e5eaab990')->toString(), $result->emissionUid->toString());
        self::assertSame('Краткое описание купона', $result->shortDescription);
        self::assertSame('Полное описание купона', $result->description);

        /** @var Image $imageFile */
        $imageFile = $result->imageFile;

        self::assertSame('photo_2023-09-15_14-38-21.png', $imageFile->fileName);
        self::assertSame(34258, $imageFile->fileSize);
        self::assertSame('iVBORw0KGgoAAAANSUhEUgAAAL0...by80BPggAAAABJRU5ErkJggg==', $imageFile->content);
        self::assertSame('image/png', $imageFile->mimeType);
    }

    #[TestDox('Купон без изображения, описания, срока действия')]
    public function testEmptyValues(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                    {
                      "data": {
                        "id": 1,
                        "code": "couponCode",
                        "qrContent": "https://example.com/join/couponCode",
                        "createDate": "2024-11-05T12:46:29Z",
                        "updateDate": "2024-11-08T07:21:52Z",
                        "activationDate": "2024-11-08T07:21:52Z",
                        "expiryDate": null,
                        "couponState": "Issued",
                        "emissionTitle": "Test Coupon 1",
                        "emissionId": 2,
                        "emissionUid": "01930ac5-0602-7c93-8dbb-123e5eaab990",
                        "shortDescription": null,
                        "description": null,
                        "imageFile": null
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
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $result = $loymax->publicApi('validToken')->coupons()->getCouponByNumber('couponCode');

        self::assertSame(1, $result->id);
        self::assertSame('couponCode', $result->code);
        self::assertSame(
            (new DateTimeImmutable('2024-11-05T12:46:29Z'))->format(DateTimeInterface::ATOM),
            $result->createDate->format(DateTimeInterface::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2024-11-08T07:21:52Z'))->format(DateTimeInterface::ATOM),
            $result->updateDate->format(DateTimeInterface::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2024-11-08T07:21:52Z'))->format(DateTimeInterface::ATOM),
            $result->activationDate->format(DateTimeInterface::ATOM),
        );
        self::assertNull($result->expiryDate);
        self::assertSame('Issued', $result->couponState->value);
        self::assertSame('Test Coupon 1', $result->emissionTitle);
        self::assertSame(2, $result->emissionId);
        self::assertSame(Uuid::fromString('01930ac5-0602-7c93-8dbb-123e5eaab990')->toString(), $result->emissionUid->toString());
        self::assertNull($result->shortDescription);
        self::assertNull($result->description);
        self::assertNull($result->imageFile);
    }

    #[TestDox('Купон не найден')]
    public function testEmptyDataNotFound(): void
    {
        $this->expectException(InvalidResponse::class);
        $this->expectExceptionMessage('Купон не найден или принадлежит другому клиенту.');

        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "result": {
                    "state": "Error",
                    "httpCode": 400,
                    "message": "Купон не найден или принадлежит другому клиенту.",
                    "messageCode": "Business.Base",
                    "exception": null,
                    "validationErrors": null
                  }
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi('validToken')->coupons()->getCouponByNumber('invalidCouponNumber');
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
        $loymax->publicApi('validAccessToken')->coupons()->getCouponByNumber('couponCode');
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
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi('validAccessToken')->coupons()->getCouponByNumber('couponCode');
    }

    /**
     * @param non-empty-string $couponNumber
     */
    #[DataProvider('invalidStartResetPasswordRequestDataProvider')]
    #[TestDox('Невалидные данные в запросе')]
    public function testInvalidRequestData(string $couponNumber): void
    {
        $this->expectException(InvalidArgumentException::class);

        $loymax = $this->createLoymaxClient();
        $loymax->publicApi()->coupons()->getCouponByNumber($couponNumber);
    }

    public static function invalidStartResetPasswordRequestDataProvider(): Iterator
    {
        yield 'пустой запрос' => [''];
    }
}
