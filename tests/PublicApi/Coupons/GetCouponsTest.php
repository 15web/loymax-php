<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\Coupons;

use DateTimeImmutable;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\PublicApi\Coupons\Response\CouponState;
use Studio15\Loymax\PublicApi\Coupons\Response\Image;
use Studio15\Loymax\Test\TestCase;
use Symfony\Component\Uid\Uuid;

/**
 * @internal
 */
#[TestDox('Получение списка купонов')]
final class GetCouponsTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSucceed(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                    {
                        "data": [
                            {
                                "id": 1,
                                "code": "couponCode1",
                                "qrContent": "https://example.com/join/couponCode1",
                                "createDate": "2024-11-05T12:46:29Z",
                                "updateDate": "2024-11-08T07:21:52Z",
                                "activationDate": "2024-11-08T07:21:52Z",
                                "expiryDate": "2025-11-08T07:21:52Z",
                                "couponState": "Issued",
                                "emissionTitle": "Test Coupon 1",
                                "emissionId": 11,
                                "emissionUid": "01930ac5-0602-7c93-8dbb-123e5eaab990",
                                "shortDescription": "Краткое описание купона 1",
                                "description": "Полное описание купона 1",
                                "imageFile": {
                                    "fileName": "photo_2023-09-15_14-38-21.png",
                                    "fileSize": 34258,
                                    "content": "iVBORw0KGgoAAAANSUhEUgAAAL0...by80BPggAAAABJRU5ErkJggg==",
                                    "mimeType": "image/png"
                                }
                            },
                            {
                                "id": 2,
                                "code": "couponCode2",
                                "qrContent": "https://example.com/join/couponCode2",
                                "createDate": "2024-11-06T12:46:29Z",
                                "updateDate": "2024-11-09T07:21:52Z",
                                "activationDate": "2024-12-08T07:21:52Z",
                                "expiryDate": null,
                                "couponState": "Used",
                                "emissionTitle": "Test Coupon 2",
                                "emissionId": 12,
                                "emissionUid": "01930c38-4b7e-7784-90e1-d7909ff088d3",
                                "shortDescription": null,
                                "description": "Полное описание купона 2",
                                "imageFile": {
                                    "fileName": "photo_2024-09-15_14-38-21.png",
                                    "fileSize": 44258,
                                    "content": "oLklFw0KGgoAAAAL0...by80BJRU5ErkJggg==",
                                    "mimeType": "image/jpeg"
                                }
                            },
                            {
                                "id": 3,
                                "code": "couponCode3",
                                "qrContent": "https://example.com/join/couponCode3",
                                "createDate": "2024-11-07T12:46:29Z",
                                "updateDate": "2024-11-10T07:21:52Z",
                                "activationDate": "2025-01-08T07:21:52Z",
                                "expiryDate": null,
                                "couponState": "QueuedToUse",
                                "emissionTitle": "Test Coupon 3",
                                "emissionId": 13,
                                "emissionUid": "01930c38-7191-7918-bf0f-3c37f460a4e6",
                                "shortDescription": "Краткое описание купона 3",
                                "description": null,
                                "imageFile": null
                            }
                        ],
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
        $result = $loymax->publicApi()->coupons()->getCoupons();

        self::assertCount(3, $result);

        self::assertSame(1, $result[0]->id);
        self::assertSame('couponCode1', $result[0]->code);
        self::assertSame(
            (new DateTimeImmutable('2024-11-05T12:46:29Z'))->format(DateTimeImmutable::ATOM),
            $result[0]->createDate->format(DateTimeImmutable::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2024-11-08T07:21:52Z'))->format(DateTimeImmutable::ATOM),
            $result[0]->updateDate->format(DateTimeImmutable::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2024-11-08T07:21:52Z'))->format(DateTimeImmutable::ATOM),
            $result[0]->activationDate->format(DateTimeImmutable::ATOM),
        );

        /** @var DateTimeImmutable $expiryDate */
        $expiryDate = $result[0]->expiryDate;
        self::assertSame(
            (new DateTimeImmutable('2025-11-08T07:21:52Z'))->format(DateTimeImmutable::ATOM),
            $expiryDate->format(DateTimeImmutable::ATOM),
        );

        self::assertSame('Issued', $result[0]->couponState->value);
        self::assertSame('Test Coupon 1', $result[0]->emissionTitle);
        self::assertSame(11, $result[0]->emissionId);
        self::assertSame(Uuid::fromString('01930ac5-0602-7c93-8dbb-123e5eaab990')->toString(), $result[0]->emissionUid->toString());
        self::assertSame('Краткое описание купона 1', $result[0]->shortDescription);
        self::assertSame('Полное описание купона 1', $result[0]->description);

        /** @var Image $imageFile */
        $imageFile = $result[0]->imageFile;

        self::assertSame('photo_2023-09-15_14-38-21.png', $imageFile->fileName);
        self::assertSame(34258, $imageFile->fileSize);
        self::assertSame('iVBORw0KGgoAAAANSUhEUgAAAL0...by80BPggAAAABJRU5ErkJggg==', $imageFile->content);
        self::assertSame('image/png', $imageFile->mimeType);

        self::assertSame(2, $result[1]->id);
        self::assertSame('couponCode2', $result[1]->code);
        self::assertSame(
            (new DateTimeImmutable('2024-11-06T12:46:29Z'))->format(DateTimeImmutable::ATOM),
            $result[1]->createDate->format(DateTimeImmutable::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2024-11-09T07:21:52Z'))->format(DateTimeImmutable::ATOM),
            $result[1]->updateDate->format(DateTimeImmutable::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2024-12-08T07:21:52Z'))->format(DateTimeImmutable::ATOM),
            $result[1]->activationDate->format(DateTimeImmutable::ATOM),
        );

        self::assertNull($result[1]->expiryDate);

        self::assertSame('Used', $result[1]->couponState->value);
        self::assertSame('Test Coupon 2', $result[1]->emissionTitle);
        self::assertSame(12, $result[1]->emissionId);
        self::assertSame(Uuid::fromString('01930c38-4b7e-7784-90e1-d7909ff088d3')->toString(), $result[1]->emissionUid->toString());
        self::assertNull($result[1]->shortDescription);
        self::assertSame('Полное описание купона 2', $result[1]->description);

        /** @var Image $imageFile */
        $imageFile = $result[1]->imageFile;

        self::assertSame('photo_2024-09-15_14-38-21.png', $imageFile->fileName);
        self::assertSame(44258, $imageFile->fileSize);
        self::assertSame('oLklFw0KGgoAAAAL0...by80BJRU5ErkJggg==', $imageFile->content);
        self::assertSame('image/jpeg', $imageFile->mimeType);

        self::assertSame(3, $result[2]->id);
        self::assertSame('couponCode3', $result[2]->code);
        self::assertSame(
            (new DateTimeImmutable('2024-11-07T12:46:29Z'))->format(DateTimeImmutable::ATOM),
            $result[2]->createDate->format(DateTimeImmutable::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2024-11-10T07:21:52Z'))->format(DateTimeImmutable::ATOM),
            $result[2]->updateDate->format(DateTimeImmutable::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2025-01-08T07:21:52Z'))->format(DateTimeImmutable::ATOM),
            $result[2]->activationDate->format(DateTimeImmutable::ATOM),
        );

        self::assertNull($result[2]->expiryDate);

        self::assertSame('QueuedToUse', $result[2]->couponState->value);
        self::assertSame('Test Coupon 3', $result[2]->emissionTitle);
        self::assertSame(13, $result[2]->emissionId);
        self::assertSame(Uuid::fromString('01930c38-7191-7918-bf0f-3c37f460a4e6')->toString(), $result[2]->emissionUid->toString());
        self::assertSame('Краткое описание купона 3', $result[2]->shortDescription);
        self::assertNull($result[2]->description);
        self::assertNull($result[2]->imageFile);
    }

    #[TestDox('Успешный результат, пагинация')]
    public function testPagination(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                    {
                        "data": [
                            {
                                "id": 1,
                                "code": "couponCode1",
                                "qrContent": "https://example.com/join/couponCode1",
                                "createDate": "2024-11-05T12:46:29Z",
                                "updateDate": "2024-11-08T07:21:52Z",
                                "activationDate": "2024-11-08T07:21:52Z",
                                "expiryDate": "2025-11-08T07:21:52Z",
                                "couponState": "Issued",
                                "emissionTitle": "Test Coupon 1",
                                "emissionId": 11,
                                "emissionUid": "01930ac5-0602-7c93-8dbb-123e5eaab990",
                                "shortDescription": "Краткое описание купона 1",
                                "description": "Полное описание купона 1",
                                "imageFile": {
                                    "fileName": "photo_2023-09-15_14-38-21.png",
                                    "fileSize": 34258,
                                    "content": "iVBORw0KGgoAAAANSUhEUgAAAL0...by80BPggAAAABJRU5ErkJggg==",
                                    "mimeType": "image/png"
                                }
                            },
                            {
                                "id": 2,
                                "code": "couponCode2",
                                "qrContent": "https://example.com/join/couponCode2",
                                "createDate": "2024-11-06T12:46:29Z",
                                "updateDate": "2024-11-09T07:21:52Z",
                                "activationDate": "2024-12-08T07:21:52Z",
                                "expiryDate": null,
                                "couponState": "Used",
                                "emissionTitle": "Test Coupon 2",
                                "emissionId": 12,
                                "emissionUid": "01930c38-4b7e-7784-90e1-d7909ff088d3",
                                "shortDescription": null,
                                "description": "Полное описание купона 2",
                                "imageFile": {
                                    "fileName": "photo_2024-09-15_14-38-21.png",
                                    "fileSize": 44258,
                                    "content": "oLklFw0KGgoAAAAL0...by80BJRU5ErkJggg==",
                                    "mimeType": "image/jpeg"
                                }
                            }
                        ],
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
        $result = $loymax->publicApi()->coupons()->getCoupons(
            count: 2,
        );

        self::assertCount(2, $result);

        self::assertSame(1, $result[0]->id);
        self::assertSame('couponCode1', $result[0]->code);
        self::assertSame(
            (new DateTimeImmutable('2024-11-05T12:46:29Z'))->format(DateTimeImmutable::ATOM),
            $result[0]->createDate->format(DateTimeImmutable::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2024-11-08T07:21:52Z'))->format(DateTimeImmutable::ATOM),
            $result[0]->updateDate->format(DateTimeImmutable::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2024-11-08T07:21:52Z'))->format(DateTimeImmutable::ATOM),
            $result[0]->activationDate->format(DateTimeImmutable::ATOM),
        );

        /** @var DateTimeImmutable $expiryDate */
        $expiryDate = $result[0]->expiryDate;
        self::assertSame(
            (new DateTimeImmutable('2025-11-08T07:21:52Z'))->format(DateTimeImmutable::ATOM),
            $expiryDate->format(DateTimeImmutable::ATOM),
        );

        self::assertSame('Issued', $result[0]->couponState->value);
        self::assertSame('Test Coupon 1', $result[0]->emissionTitle);
        self::assertSame(11, $result[0]->emissionId);
        self::assertSame(Uuid::fromString('01930ac5-0602-7c93-8dbb-123e5eaab990')->toString(), $result[0]->emissionUid->toString());
        self::assertSame('Краткое описание купона 1', $result[0]->shortDescription);
        self::assertSame('Полное описание купона 1', $result[0]->description);

        /** @var Image $imageFile */
        $imageFile = $result[0]->imageFile;

        self::assertSame('photo_2023-09-15_14-38-21.png', $imageFile->fileName);
        self::assertSame(34258, $imageFile->fileSize);
        self::assertSame('iVBORw0KGgoAAAANSUhEUgAAAL0...by80BPggAAAABJRU5ErkJggg==', $imageFile->content);
        self::assertSame('image/png', $imageFile->mimeType);

        self::assertSame(2, $result[1]->id);
        self::assertSame('couponCode2', $result[1]->code);
        self::assertSame(
            (new DateTimeImmutable('2024-11-06T12:46:29Z'))->format(DateTimeImmutable::ATOM),
            $result[1]->createDate->format(DateTimeImmutable::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2024-11-09T07:21:52Z'))->format(DateTimeImmutable::ATOM),
            $result[1]->updateDate->format(DateTimeImmutable::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2024-12-08T07:21:52Z'))->format(DateTimeImmutable::ATOM),
            $result[1]->activationDate->format(DateTimeImmutable::ATOM),
        );

        self::assertNull($result[1]->expiryDate);

        self::assertSame('Used', $result[1]->couponState->value);
        self::assertSame('Test Coupon 2', $result[1]->emissionTitle);
        self::assertSame(12, $result[1]->emissionId);
        self::assertSame(Uuid::fromString('01930c38-4b7e-7784-90e1-d7909ff088d3')->toString(), $result[1]->emissionUid->toString());
        self::assertNull($result[1]->shortDescription);
        self::assertSame('Полное описание купона 2', $result[1]->description);

        /** @var Image $imageFile */
        $imageFile = $result[1]->imageFile;

        self::assertSame('photo_2024-09-15_14-38-21.png', $imageFile->fileName);
        self::assertSame(44258, $imageFile->fileSize);
        self::assertSame('oLklFw0KGgoAAAAL0...by80BJRU5ErkJggg==', $imageFile->content);
        self::assertSame('image/jpeg', $imageFile->mimeType);

        $mockResponse = new Response(
            body: <<<'JSON'
                    {
                        "data": [
                            {
                                "id": 3,
                                "code": "couponCode3",
                                "qrContent": "https://example.com/join/couponCode3",
                                "createDate": "2024-11-07T12:46:29Z",
                                "updateDate": "2024-11-10T07:21:52Z",
                                "activationDate": "2025-01-08T07:21:52Z",
                                "expiryDate": null,
                                "couponState": "QueuedToUse",
                                "emissionTitle": "Test Coupon 3",
                                "emissionId": 13,
                                "emissionUid": "01930c38-7191-7918-bf0f-3c37f460a4e6",
                                "shortDescription": "Краткое описание купона 3",
                                "description": null,
                                "imageFile": null
                            }
                        ],
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
        $result = $loymax->publicApi()->coupons()->getCoupons(
            from: 2,
            count: 2,
        );

        self::assertCount(1, $result);

        self::assertSame(3, $result[0]->id);
        self::assertSame('couponCode3', $result[0]->code);
        self::assertSame(
            (new DateTimeImmutable('2024-11-07T12:46:29Z'))->format(DateTimeImmutable::ATOM),
            $result[0]->createDate->format(DateTimeImmutable::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2024-11-10T07:21:52Z'))->format(DateTimeImmutable::ATOM),
            $result[0]->updateDate->format(DateTimeImmutable::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2025-01-08T07:21:52Z'))->format(DateTimeImmutable::ATOM),
            $result[0]->activationDate->format(DateTimeImmutable::ATOM),
        );

        self::assertNull($result[0]->expiryDate);

        self::assertSame('QueuedToUse', $result[0]->couponState->value);
        self::assertSame('Test Coupon 3', $result[0]->emissionTitle);
        self::assertSame(13, $result[0]->emissionId);
        self::assertSame(Uuid::fromString('01930c38-7191-7918-bf0f-3c37f460a4e6')->toString(), $result[0]->emissionUid->toString());
        self::assertSame('Краткое описание купона 3', $result[0]->shortDescription);
        self::assertNull($result[0]->description);
        self::assertNull($result[0]->imageFile);
    }

    #[TestDox('Фильтр по внутренним идентификаторам выпуска купонов')]
    public function testEmissionIdsFilter(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                    {
                        "data": [
                            {
                                "id": 11,
                                "code": "couponCode11",
                                "qrContent": "https://example.com/join/couponCode11",
                                "createDate": "2024-11-07T12:46:29Z",
                                "updateDate": "2024-11-07T12:46:29Z",
                                "activationDate": "2024-11-07T12:46:29Z",
                                "expiryDate": null,
                                "couponState": "Issued",
                                "emissionTitle": "Test Coupon 11",
                                "emissionId": 111,
                                "emissionUid": "01930d35-5264-7ca9-8e84-1e3f6a09144e",
                                "shortDescription": null,
                                "description": null,
                                "imageFile": null
                            }
                        ],
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
        $result = $loymax->publicApi()->coupons()->getCoupons(
            emissionIds: [111],
        );

        self::assertCount(1, $result);

        self::assertSame(11, $result[0]->id);
        self::assertSame('couponCode11', $result[0]->code);
        self::assertSame(
            (new DateTimeImmutable('2024-11-07T12:46:29Z'))->format(DateTimeImmutable::ATOM),
            $result[0]->createDate->format(DateTimeImmutable::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2024-11-07T12:46:29Z'))->format(DateTimeImmutable::ATOM),
            $result[0]->updateDate->format(DateTimeImmutable::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2024-11-07T12:46:29Z'))->format(DateTimeImmutable::ATOM),
            $result[0]->activationDate->format(DateTimeImmutable::ATOM),
        );

        self::assertNull($result[0]->expiryDate);

        self::assertSame('Issued', $result[0]->couponState->value);
        self::assertSame('Test Coupon 11', $result[0]->emissionTitle);
        self::assertSame(111, $result[0]->emissionId);
        self::assertSame(Uuid::fromString('01930d35-5264-7ca9-8e84-1e3f6a09144e')->toString(), $result[0]->emissionUid->toString());
        self::assertNull($result[0]->shortDescription);
        self::assertNull($result[0]->description);
        self::assertNull($result[0]->imageFile);
    }

    #[TestDox('Фильтр по статусам купонов')]
    public function testCouponStatesFilter(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                    {
                        "data": [
                            {
                                "id": 12,
                                "code": "couponCode12",
                                "qrContent": "https://example.com/join/couponCode12",
                                "createDate": "2024-11-07T12:46:29Z",
                                "updateDate": "2024-11-07T12:46:29Z",
                                "activationDate": "2024-11-07T12:46:29Z",
                                "expiryDate": null,
                                "couponState": "Used",
                                "emissionTitle": "Test Coupon 12",
                                "emissionId": 112,
                                "emissionUid": "01930d36-bee4-7822-a579-a90310f8eecd",
                                "shortDescription": null,
                                "description": null,
                                "imageFile": null
                            }
                        ],
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
        $result = $loymax->publicApi()->coupons()->getCoupons(
            couponStates: [CouponState::Used],
        );

        self::assertCount(1, $result);

        self::assertSame(12, $result[0]->id);
        self::assertSame('couponCode12', $result[0]->code);
        self::assertSame(
            (new DateTimeImmutable('2024-11-07T12:46:29Z'))->format(DateTimeImmutable::ATOM),
            $result[0]->createDate->format(DateTimeImmutable::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2024-11-07T12:46:29Z'))->format(DateTimeImmutable::ATOM),
            $result[0]->updateDate->format(DateTimeImmutable::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2024-11-07T12:46:29Z'))->format(DateTimeImmutable::ATOM),
            $result[0]->activationDate->format(DateTimeImmutable::ATOM),
        );

        self::assertNull($result[0]->expiryDate);

        self::assertSame('Used', $result[0]->couponState->value);
        self::assertSame('Test Coupon 12', $result[0]->emissionTitle);
        self::assertSame(112, $result[0]->emissionId);
        self::assertSame(Uuid::fromString('01930d36-bee4-7822-a579-a90310f8eecd')->toString(), $result[0]->emissionUid->toString());
        self::assertNull($result[0]->shortDescription);
        self::assertNull($result[0]->description);
        self::assertNull($result[0]->imageFile);
    }

    #[TestDox('Фильтр по дате начала периода изменения статуса')]
    public function testChangedStateDateFromFilter(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                    {
                        "data": [
                            {
                                "id": 13,
                                "code": "couponCode13",
                                "qrContent": "https://example.com/join/couponCode13",
                                "createDate": "2024-11-07T12:46:29Z",
                                "updateDate": "2024-11-07T12:46:29Z",
                                "activationDate": "2024-11-07T12:46:29Z",
                                "expiryDate": null,
                                "couponState": "Issued",
                                "emissionTitle": "Test Coupon 13",
                                "emissionId": 113,
                                "emissionUid": "01930d36-f79c-7200-be75-07208cb5c362",
                                "shortDescription": null,
                                "description": null,
                                "imageFile": null
                            }
                        ],
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
        $result = $loymax->publicApi()->coupons()->getCoupons(
            changedStateDateFrom: new DateTimeImmutable('2024-11-00T00:00:00Z'),
        );

        self::assertCount(1, $result);

        self::assertSame(13, $result[0]->id);
        self::assertSame('couponCode13', $result[0]->code);
        self::assertSame(
            (new DateTimeImmutable('2024-11-07T12:46:29Z'))->format(DateTimeImmutable::ATOM),
            $result[0]->createDate->format(DateTimeImmutable::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2024-11-07T12:46:29Z'))->format(DateTimeImmutable::ATOM),
            $result[0]->updateDate->format(DateTimeImmutable::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2024-11-07T12:46:29Z'))->format(DateTimeImmutable::ATOM),
            $result[0]->activationDate->format(DateTimeImmutable::ATOM),
        );

        self::assertNull($result[0]->expiryDate);

        self::assertSame('Issued', $result[0]->couponState->value);
        self::assertSame('Test Coupon 13', $result[0]->emissionTitle);
        self::assertSame(113, $result[0]->emissionId);
        self::assertSame(Uuid::fromString('01930d36-f79c-7200-be75-07208cb5c362')->toString(), $result[0]->emissionUid->toString());
        self::assertNull($result[0]->shortDescription);
        self::assertNull($result[0]->description);
        self::assertNull($result[0]->imageFile);
    }

    #[TestDox('Фильтр по дате окончания периода изменения статуса')]
    public function testChangedStateDateToFilter(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                    {
                        "data": [
                            {
                                "id": 14,
                                "code": "couponCode14",
                                "qrContent": "https://example.com/join/couponCode14",
                                "createDate": "2024-11-07T12:46:29Z",
                                "updateDate": "2024-11-07T12:46:29Z",
                                "activationDate": "2024-11-07T12:46:29Z",
                                "expiryDate": null,
                                "couponState": "Issued",
                                "emissionTitle": "Test Coupon 14",
                                "emissionId": 114,
                                "emissionUid": "01930d37-1c6c-7f91-9402-5f7e74738df9",
                                "shortDescription": null,
                                "description": null,
                                "imageFile": null
                            }
                        ],
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
        $result = $loymax->publicApi()->coupons()->getCoupons(
            changedStateDateTo: new DateTimeImmutable('2024-12-00T00:00:00Z'),
        );

        self::assertCount(1, $result);

        self::assertSame(14, $result[0]->id);
        self::assertSame('couponCode14', $result[0]->code);
        self::assertSame(
            (new DateTimeImmutable('2024-11-07T12:46:29Z'))->format(DateTimeImmutable::ATOM),
            $result[0]->createDate->format(DateTimeImmutable::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2024-11-07T12:46:29Z'))->format(DateTimeImmutable::ATOM),
            $result[0]->updateDate->format(DateTimeImmutable::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2024-11-07T12:46:29Z'))->format(DateTimeImmutable::ATOM),
            $result[0]->activationDate->format(DateTimeImmutable::ATOM),
        );

        self::assertNull($result[0]->expiryDate);

        self::assertSame('Issued', $result[0]->couponState->value);
        self::assertSame('Test Coupon 14', $result[0]->emissionTitle);
        self::assertSame(114, $result[0]->emissionId);
        self::assertSame(Uuid::fromString('01930d37-1c6c-7f91-9402-5f7e74738df9')->toString(), $result[0]->emissionUid->toString());
        self::assertNull($result[0]->shortDescription);
        self::assertNull($result[0]->description);
        self::assertNull($result[0]->imageFile);
    }

    #[TestDox('Фильтр по номеру купона')]
    public function testCouponNumberFilter(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                    {
                        "data": [
                            {
                                "id": 15,
                                "code": "couponCode15",
                                "qrContent": "https://example.com/join/couponCode15",
                                "createDate": "2024-11-07T12:46:29Z",
                                "updateDate": "2024-11-07T12:46:29Z",
                                "activationDate": "2024-11-07T12:46:29Z",
                                "expiryDate": null,
                                "couponState": "Issued",
                                "emissionTitle": "Test Coupon 15",
                                "emissionId": 115,
                                "emissionUid": "01930d37-384b-7846-a878-0e926da09524",
                                "shortDescription": null,
                                "description": null,
                                "imageFile": null
                            }
                        ],
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
        $result = $loymax->publicApi()->coupons()->getCoupons(
            couponNumber: 'couponCode15',
        );

        self::assertCount(1, $result);

        self::assertSame(15, $result[0]->id);
        self::assertSame('couponCode15', $result[0]->code);
        self::assertSame(
            (new DateTimeImmutable('2024-11-07T12:46:29Z'))->format(DateTimeImmutable::ATOM),
            $result[0]->createDate->format(DateTimeImmutable::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2024-11-07T12:46:29Z'))->format(DateTimeImmutable::ATOM),
            $result[0]->updateDate->format(DateTimeImmutable::ATOM),
        );
        self::assertSame(
            (new DateTimeImmutable('2024-11-07T12:46:29Z'))->format(DateTimeImmutable::ATOM),
            $result[0]->activationDate->format(DateTimeImmutable::ATOM),
        );

        self::assertNull($result[0]->expiryDate);

        self::assertSame('Issued', $result[0]->couponState->value);
        self::assertSame('Test Coupon 15', $result[0]->emissionTitle);
        self::assertSame(115, $result[0]->emissionId);
        self::assertSame(Uuid::fromString('01930d37-384b-7846-a878-0e926da09524')->toString(), $result[0]->emissionUid->toString());
        self::assertNull($result[0]->shortDescription);
        self::assertNull($result[0]->description);
        self::assertNull($result[0]->imageFile);
    }

    #[TestDox('Записей не найдено')]
    public function testEmptyData(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": [],
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
        $result = $loymax->publicApi()->coupons()->getCoupons();

        self::assertSame([], $result);
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
        $loymax->publicApi()->coupons()->getCoupons();
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
        $loymax->publicApi('validAccessToken')->coupons()->getCoupons();
    }
}
