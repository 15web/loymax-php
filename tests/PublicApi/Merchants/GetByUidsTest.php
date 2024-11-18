<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\Merchants;

use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\PublicApi\Merchants\Response\AdditionalInfo;
use Studio15\Loymax\PublicApi\Merchants\Response\Schedule;
use Studio15\Loymax\PublicApi\Merchants\Response\ScheduleModel;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Получение информации о торговых точках (фильтр по внешним идентификаторам торговых точек)')]
final class GetByUidsTest extends TestCase
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
                          "uid": "cf4dd4a7-c807-c999-c40b-450dd73f5e28",
                          "title": "Московская обл.",
                          "internalTitle": "Маркет 1",
                          "brandUid": "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2",
                          "brandId": "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2",
                          "location": {
                            "id": 1,
                            "locationId": "3ab06b51-4a70-2e12-75e5-9009cbfd03ff",
                            "description": "г. Москва, Новомосковская, 32",
                            "latitude": 56.351121,
                            "longitude": 30.489791,
                            "region": null,
                            "city": {
                              "id": 1,
                              "region": null,
                              "name": "Москва",
                              "prefix": "г."
                            },
                            "street": "Новомосковская",
                            "house": "32",
                            "building": null,
                            "office": null
                          },
                          "scheduleModel": {
                            "mon": [
                              {
                                "to": "19:00",
                                "from": "10:00"
                              }
                            ],
                            "tue": null,
                            "wed": null,
                            "thu": null,
                            "fri": [
                              {
                                "to": "19:00",
                                "from": "10:00"
                              }
                            ],
                            "sat": null,
                            "sun": null
                          },
                          "isArchived": false,
                          "contacts": null,
                          "description": "",
                          "additionalInfo": [
                            {
                              "name": "Town",
                              "value": "Москва"
                            }
                          ]
                        },
                        {
                          "id": 2,
                          "uid": "36e803b6-a7b8-a3ff-9992-82568a5e09d0",
                          "title": "Московская обл.",
                          "internalTitle": "Маркет 16",
                          "brandUid": "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2",
                          "brandId": "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2",
                          "location": {
                            "id": 2,
                            "locationId": "9076ad20-3682-7662-9711-b736b5a475f8",
                            "description": "г. Москва, Вокзальная, 28",
                            "latitude": 56.349819,
                            "longitude": 30.562213,
                            "region": null,
                            "city": {
                              "id": 1,
                              "region": null,
                              "name": "Москва",
                              "prefix": "г."
                            },
                            "street": "Вокзальная",
                            "house": "28",
                            "building": null,
                            "office": null
                          },
                          "scheduleModel": {
                            "mon": [
                              {
                                "to": "11:00",
                                "from": "09:00"
                              },
                              {
                                "to": "15:00",
                                "from": "12:00"
                              }
                            ],
                            "tue": null,
                            "wed": null,
                            "thu": null,
                            "fri": null,
                            "sat": null,
                            "sun": [
                              {
                                "to": "20:00",
                                "from": "09:00"
                              }
                            ]
                          },
                          "isArchived": false,
                          "contacts": null,
                          "description": "",
                          "additionalInfo": [
                            {
                              "name": "Brand",
                              "value": "Супермаркет"
                            },
                            {
                              "name": "City",
                              "value": "Москва"
                            }
                          ]
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
                JSON
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $result = $loymax->publicApi()->merchants()->getByUids();

        self::assertCount(2, $result);

        self::assertSame(1, $result[0]->id);
        self::assertSame('cf4dd4a7-c807-c999-c40b-450dd73f5e28', $result[0]->uid);
        self::assertSame('Московская обл.', $result[0]->title);
        self::assertSame('b77a6015-ac3c-53a8-2d47-5cc7be21e3f2', $result[0]->brandId);
        self::assertSame('', $result[0]->description);
        self::assertSame(1, $result[0]->location->id);
        self::assertSame('г. Москва, Новомосковская, 32', $result[0]->location->description);
        self::assertEqualsWithDelta(56.351121, $result[0]->location->latitude, PHP_FLOAT_EPSILON);
        self::assertEqualsWithDelta(30.489791, $result[0]->location->longitude, PHP_FLOAT_EPSILON);
        self::assertSame(1, $result[0]->location->city->id);
        self::assertSame('Москва', $result[0]->location->city->name);
        self::assertSame('г.', $result[0]->location->city->prefix);
        self::assertSame('Новомосковская', $result[0]->location->street);
        self::assertSame('32', $result[0]->location->house);
        self::assertNull($result[0]->location->building);
        self::assertNull($result[0]->location->office);

        /** @var ScheduleModel $scheduleModel */
        $scheduleModel = $result[0]->scheduleModel;

        /** @var list<Schedule> $scheduleMon */
        $scheduleMon = $scheduleModel->mon;
        self::assertCount(1, $scheduleMon);
        self::assertSame('10:00', $scheduleMon[0]->from);
        self::assertSame('19:00', $scheduleMon[0]->to);
        self::assertNull($scheduleModel->tue);
        self::assertNull($scheduleModel->wed);
        self::assertNull($scheduleModel->thu);

        /** @var list<Schedule> $scheduleFri */
        $scheduleFri = $scheduleModel->fri;
        self::assertCount(1, $scheduleFri);
        self::assertSame('10:00', $scheduleFri[0]->from);
        self::assertSame('19:00', $scheduleFri[0]->to);
        self::assertNull($scheduleModel->sat);
        self::assertNull($scheduleModel->sun);
        self::assertFalse($result[0]->isArchived);

        /** @var list<AdditionalInfo> $additionalInfo */
        $additionalInfo = $result[0]->additionalInfo;
        self::assertCount(1, $additionalInfo);
        self::assertSame('Town', $additionalInfo[0]->name);
        self::assertSame('Москва', $additionalInfo[0]->value);

        self::assertSame(2, $result[1]->id);
        self::assertSame('36e803b6-a7b8-a3ff-9992-82568a5e09d0', $result[1]->uid);
        self::assertSame('Московская обл.', $result[1]->title);
        self::assertSame('b77a6015-ac3c-53a8-2d47-5cc7be21e3f2', $result[1]->brandId);
        self::assertSame('', $result[1]->description);
        self::assertSame(2, $result[1]->location->id);
        self::assertSame('г. Москва, Вокзальная, 28', $result[1]->location->description);
        self::assertEqualsWithDelta(56.349819, $result[1]->location->latitude, PHP_FLOAT_EPSILON);
        self::assertEqualsWithDelta(30.562213, $result[1]->location->longitude, PHP_FLOAT_EPSILON);
        self::assertSame(1, $result[1]->location->city->id);
        self::assertSame('Москва', $result[1]->location->city->name);
        self::assertSame('г.', $result[1]->location->city->prefix);
        self::assertSame('Вокзальная', $result[1]->location->street);
        self::assertSame('28', $result[1]->location->house);
        self::assertNull($result[1]->location->building);
        self::assertNull($result[1]->location->office);

        /** @var ScheduleModel $scheduleModel */
        $scheduleModel = $result[1]->scheduleModel;

        /** @var list<Schedule> $scheduleMon */
        $scheduleMon = $scheduleModel->mon;
        self::assertCount(2, $scheduleMon);
        self::assertSame('09:00', $scheduleMon[0]->from);
        self::assertSame('11:00', $scheduleMon[0]->to);
        self::assertSame('12:00', $scheduleMon[1]->from);
        self::assertSame('15:00', $scheduleMon[1]->to);
        self::assertNull($scheduleModel->tue);
        self::assertNull($scheduleModel->wed);
        self::assertNull($scheduleModel->thu);
        self::assertNull($scheduleModel->fri);
        self::assertNull($scheduleModel->sat);

        /** @var list<Schedule> $scheduleSun */
        $scheduleSun = $scheduleModel->sun;
        self::assertCount(1, $scheduleSun);
        self::assertSame('09:00', $scheduleSun[0]->from);
        self::assertSame('20:00', $scheduleSun[0]->to);
        self::assertFalse($result[1]->isArchived);

        /** @var list<AdditionalInfo> $additionalInfo */
        $additionalInfo = $result[1]->additionalInfo;
        self::assertCount(2, $additionalInfo);
        self::assertSame('Brand', $additionalInfo[0]->name);
        self::assertSame('Супермаркет', $additionalInfo[0]->value);
        self::assertSame('City', $additionalInfo[1]->name);
        self::assertSame('Москва', $additionalInfo[1]->value);
    }

    #[TestDox('Успешный результат с фильтром по внешним идентификаторам торговых точек')]
    public function testByIdsSucceed(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                    {
                      "data": [
                        {
                          "id": 1,
                          "uid": "cf4dd4a7-c807-c999-c40b-450dd73f5e28",
                          "title": "Московская обл.",
                          "internalTitle": "Маркет 1",
                          "brandUid": "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2",
                          "brandId": "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2",
                          "location": {
                            "id": 1,
                            "locationId": "3ab06b51-4a70-2e12-75e5-9009cbfd03ff",
                            "description": "г. Москва, Новомосковская, 32",
                            "latitude": 56.351121,
                            "longitude": 30.489791,
                            "region": null,
                            "city": {
                              "id": 1,
                              "region": null,
                              "name": "Москва",
                              "prefix": "г."
                            },
                            "street": "Новомосковская",
                            "house": "32",
                            "building": null,
                            "office": null
                          },
                          "scheduleModel": {
                            "mon": [
                              {
                                "to": "19:00",
                                "from": "10:00"
                              }
                            ],
                            "tue": null,
                            "wed": null,
                            "thu": null,
                            "fri": [
                              {
                                "to": "19:00",
                                "from": "10:00"
                              }
                            ],
                            "sat": null,
                            "sun": null
                          },
                          "isArchived": false,
                          "contacts": null,
                          "description": "",
                          "additionalInfo": [
                            {
                              "name": "Town",
                              "value": "Москва"
                            }
                          ]
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
                JSON
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $result = $loymax->publicApi()->merchants()->getByUids(
            merchantsUids: ['cf4dd4a7-c807-c999-c40b-450dd73f5e28'],
        );

        self::assertCount(1, $result);

        self::assertSame(1, $result[0]->id);
        self::assertSame('cf4dd4a7-c807-c999-c40b-450dd73f5e28', $result[0]->uid);
        self::assertSame('Московская обл.', $result[0]->title);
        self::assertSame('b77a6015-ac3c-53a8-2d47-5cc7be21e3f2', $result[0]->brandId);
        self::assertSame('', $result[0]->description);
        self::assertSame(1, $result[0]->location->id);
        self::assertSame('г. Москва, Новомосковская, 32', $result[0]->location->description);
        self::assertEqualsWithDelta(56.351121, $result[0]->location->latitude, PHP_FLOAT_EPSILON);
        self::assertEqualsWithDelta(30.489791, $result[0]->location->longitude, PHP_FLOAT_EPSILON);
        self::assertSame(1, $result[0]->location->city->id);
        self::assertSame('Москва', $result[0]->location->city->name);
        self::assertSame('г.', $result[0]->location->city->prefix);
        self::assertSame('Новомосковская', $result[0]->location->street);
        self::assertSame('32', $result[0]->location->house);
        self::assertNull($result[0]->location->building);
        self::assertNull($result[0]->location->office);

        /** @var ScheduleModel $scheduleModel */
        $scheduleModel = $result[0]->scheduleModel;

        /** @var list<Schedule> $scheduleMon */
        $scheduleMon = $scheduleModel->mon;
        self::assertCount(1, $scheduleMon);
        self::assertSame('10:00', $scheduleMon[0]->from);
        self::assertSame('19:00', $scheduleMon[0]->to);
        self::assertNull($scheduleModel->tue);
        self::assertNull($scheduleModel->wed);
        self::assertNull($scheduleModel->thu);

        /** @var list<Schedule> $scheduleFri */
        $scheduleFri = $scheduleModel->fri;
        self::assertCount(1, $scheduleFri);
        self::assertSame('10:00', $scheduleFri[0]->from);
        self::assertSame('19:00', $scheduleFri[0]->to);
        self::assertNull($scheduleModel->sat);
        self::assertNull($scheduleModel->sun);
        self::assertFalse($result[0]->isArchived);

        /** @var list<AdditionalInfo> $additionalInfo */
        $additionalInfo = $result[0]->additionalInfo;
        self::assertCount(1, $additionalInfo);
        self::assertSame('Town', $additionalInfo[0]->name);
        self::assertSame('Москва', $additionalInfo[0]->value);
    }

    #[TestDox('Успешный результат, пагинация')]
    public function testPagination(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                    {
                      "data": [
                        {
                          "id": 2,
                          "uid": "36e803b6-a7b8-a3ff-9992-82568a5e09d0",
                          "title": "Московская обл.",
                          "internalTitle": "Маркет 16",
                          "brandUid": "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2",
                          "brandId": "b77a6015-ac3c-53a8-2d47-5cc7be21e3f2",
                          "location": {
                            "id": 2,
                            "locationId": "9076ad20-3682-7662-9711-b736b5a475f8",
                            "description": "г. Москва, Вокзальная, 28",
                            "latitude": 56.349819,
                            "longitude": 30.562213,
                            "region": null,
                            "city": {
                              "id": 1,
                              "region": null,
                              "name": "Москва",
                              "prefix": "г."
                            },
                            "street": "Вокзальная",
                            "house": "28",
                            "building": null,
                            "office": null
                          },
                          "scheduleModel": {
                            "mon": [
                              {
                                "to": "11:00",
                                "from": "09:00"
                              },
                              {
                                "to": "15:00",
                                "from": "12:00"
                              }
                            ],
                            "tue": null,
                            "wed": null,
                            "thu": null,
                            "fri": null,
                            "sat": null,
                            "sun": [
                              {
                                "to": "20:00",
                                "from": "09:00"
                              }
                            ]
                          },
                          "isArchived": false,
                          "contacts": null,
                          "description": "",
                          "additionalInfo": [
                            {
                              "name": "Brand",
                              "value": "Супермаркет"
                            },
                            {
                              "name": "City",
                              "value": "Москва"
                            }
                          ]
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
                JSON
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $result = $loymax->publicApi()->merchants()->getByUids(
            from: 1,
            count: 1,
        );

        self::assertCount(1, $result);

        self::assertSame(2, $result[0]->id);
        self::assertSame('36e803b6-a7b8-a3ff-9992-82568a5e09d0', $result[0]->uid);
        self::assertSame('Московская обл.', $result[0]->title);
        self::assertSame('b77a6015-ac3c-53a8-2d47-5cc7be21e3f2', $result[0]->brandId);
        self::assertSame('', $result[0]->description);
        self::assertSame(2, $result[0]->location->id);
        self::assertSame('г. Москва, Вокзальная, 28', $result[0]->location->description);
        self::assertEqualsWithDelta(56.349819, $result[0]->location->latitude, PHP_FLOAT_EPSILON);
        self::assertEqualsWithDelta(30.562213, $result[0]->location->longitude, PHP_FLOAT_EPSILON);
        self::assertSame(1, $result[0]->location->city->id);
        self::assertSame('Москва', $result[0]->location->city->name);
        self::assertSame('г.', $result[0]->location->city->prefix);
        self::assertSame('Вокзальная', $result[0]->location->street);
        self::assertSame('28', $result[0]->location->house);
        self::assertNull($result[0]->location->building);
        self::assertNull($result[0]->location->office);

        /** @var ScheduleModel $scheduleModel */
        $scheduleModel = $result[0]->scheduleModel;

        /** @var list<Schedule> $scheduleMon */
        $scheduleMon = $scheduleModel->mon;
        self::assertCount(2, $scheduleMon);
        self::assertSame('09:00', $scheduleMon[0]->from);
        self::assertSame('11:00', $scheduleMon[0]->to);
        self::assertSame('12:00', $scheduleMon[1]->from);
        self::assertSame('15:00', $scheduleMon[1]->to);
        self::assertNull($scheduleModel->tue);
        self::assertNull($scheduleModel->wed);
        self::assertNull($scheduleModel->thu);
        self::assertNull($scheduleModel->fri);
        self::assertNull($scheduleModel->sat);

        /** @var list<Schedule> $scheduleSun */
        $scheduleSun = $scheduleModel->sun;
        self::assertCount(1, $scheduleSun);
        self::assertSame('09:00', $scheduleSun[0]->from);
        self::assertSame('20:00', $scheduleSun[0]->to);
        self::assertFalse($result[0]->isArchived);

        /** @var list<AdditionalInfo> $additionalInfo */
        $additionalInfo = $result[0]->additionalInfo;
        self::assertCount(2, $additionalInfo);
        self::assertSame('Brand', $additionalInfo[0]->name);
        self::assertSame('Супермаркет', $additionalInfo[0]->value);
        self::assertSame('City', $additionalInfo[1]->name);
        self::assertSame('Москва', $additionalInfo[1]->value);
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
                JSON
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $result = $loymax->publicApi()->merchants()->getByUids();

        self::assertSame([], $result);
    }

    #[TestDox('Пустой ответ')]
    public function testDataNotSet(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
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
        $result = $loymax->publicApi()->merchants()->getByUids();

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
                JSON
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);
        $loymax->publicApi()->merchants()->getByUids();
    }

    /**
     * @param array{
     *     merchantsUids: list<non-empty-string>,
     *     from: non-negative-int,
     *     count: positive-int,
     * } $data
     */
    #[DataProvider('invalidRequestDataProvider')]
    #[TestDox('Невалидные данные в запросе')]
    public function testInvalidRequestData(array $data): void
    {
        $this->expectException(InvalidArgumentException::class);

        $loymax = $this->createLoymaxClient();
        $loymax->publicApi()->merchants()->getByUids(
            merchantsUids: $data['merchantsUids'],
            from: $data['from'],
            count: $data['count'],
        );
    }

    public static function invalidRequestDataProvider(): Iterator
    {
        yield 'некорректный список Uuid' => [['merchantsUids' => ['fake'], 'from' => 0, 'count' => 10]];

        yield 'некорректный порядковый номер' => [['merchantsUids' => [1], 'from' => -10, 'count' => 10]];

        yield 'некорректное количество' => [['merchantsUids' => [1], 'from' => 0, 'count' => -10]];
    }
}
