<?php

/**
 * Команда для проверки работы SDK без dev зависимостей
 */

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Studio15\Loymax\Loymax;

require __DIR__.'/vendor/autoload.php';

$merchantResponse = new Response(
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

$client = new Client([
    'handler' => HandlerStack::create(
        new MockHandler([$merchantResponse]),
    ),
]);

$loymax = new Loymax(
    httpClient: $client,
);

$merchants = $loymax->publicApi()->merchants()->getByIds();

echo sprintf("Done, %s merchants\r\n", \count($merchants));
