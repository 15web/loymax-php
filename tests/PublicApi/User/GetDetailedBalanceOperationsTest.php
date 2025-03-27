<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\User;

use DateTimeImmutable;
use DateTimeInterface;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\PublicApi\User\Request\DetailedBalanceOperationType;
use Studio15\Loymax\Test\TestCase;
use Webmozart\Assert\InvalidArgumentException;

/**
 * @internal
 */
#[TestDox('Получение операций активации и сгорания')]
final class GetDetailedBalanceOperationsTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSucceed(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": [
                    {
                      "amount": -100.0000,
                      "date": "2025-03-23T12:40:32"
                    },
                    {
                      "amount": 55.0000,
                      "date": "2025-04-30T12:44:01"
                    },
                    {
                      "amount": 15.0000,
                      "date": "2025-05-30T11:34:15"
                    },
                    {
                      "amount": -20.0000,
                      "date": "2025-06-30T15:22:05"
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
        $result = $loymax->publicApi('validAccessToken')->user()->getDetailedBalanceOperations(1);

        self::assertCount(4, $result);

        self::assertSame(-100.0000, $result[0]->amount);
        self::assertSame('2025-03-23T12:40:32+00:00', $result[0]->date->format(DateTimeInterface::ATOM));
        self::assertSame(55.0000, $result[1]->amount);
        self::assertSame('2025-04-30T12:44:01+00:00', $result[1]->date->format(DateTimeInterface::ATOM));
        self::assertSame(15.0000, $result[2]->amount);
        self::assertSame('2025-05-30T11:34:15+00:00', $result[2]->date->format(DateTimeInterface::ATOM));
        self::assertSame(-20.0000, $result[3]->amount);
        self::assertSame('2025-06-30T15:22:05+00:00', $result[3]->date->format(DateTimeInterface::ATOM));
    }

    #[TestDox('Пагинация')]
    public function testPagination(): void
    {
        $mockResponseList = [
            new Response(
                body: <<<'JSON'
                    {
                      "data": [
                        {
                          "amount": -100.0000,
                          "date": "2025-03-23T12:40:32"
                        },
                        {
                          "amount": 55.0000,
                          "date": "2025-04-30T12:44:01"
                        },
                        {
                          "amount": 15.0000,
                          "date": "2025-05-30T11:34:15"
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
            ),
            new Response(
                body: <<<'JSON'
                    {
                      "data": [
                        {
                          "amount": -20.0000,
                          "date": "2025-06-30T15:22:05"
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
            ),
        ];

        $loymax = $this->createLoymaxClient($mockResponseList);

        $result = $loymax->publicApi('validAccessToken')->user()->getDetailedBalanceOperations(
            currencyId: 1,
            count: 3,
        );

        self::assertCount(3, $result);

        self::assertSame(-100.0000, $result[0]->amount);
        self::assertSame('2025-03-23T12:40:32+00:00', $result[0]->date->format(DateTimeInterface::ATOM));
        self::assertSame(55.0000, $result[1]->amount);
        self::assertSame('2025-04-30T12:44:01+00:00', $result[1]->date->format(DateTimeInterface::ATOM));
        self::assertSame(15.0000, $result[2]->amount);
        self::assertSame('2025-05-30T11:34:15+00:00', $result[2]->date->format(DateTimeInterface::ATOM));

        $result = $loymax->publicApi('validAccessToken')->user()->getDetailedBalanceOperations(
            currencyId: 1,
            from: 3,
        );

        self::assertCount(1, $result);

        self::assertSame(-20.0000, $result[0]->amount);
        self::assertSame('2025-06-30T15:22:05+00:00', $result[0]->date->format(DateTimeInterface::ATOM));
    }

    #[TestDox('Фильтрация')]
    public function testFilters(): void
    {
        $mockResponseList = [
            new Response(
                body: <<<'JSON'
                    {
                      "data": [
                        {
                          "amount": -20.0000,
                          "date": "2025-06-30T15:22:05"
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
            ),
            new Response(
                body: <<<'JSON'
                    {
                      "data": [
                        {
                          "amount": -100.0000,
                          "date": "2025-03-23T12:40:32"
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
            ),
            new Response(
                body: <<<'JSON'
                    {
                      "data": [
                        {
                          "amount": 55.0000,
                          "date": "2025-04-30T12:44:01"
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
            ),
            new Response(
                body: <<<'JSON'
                    {
                      "data": [
                        {
                          "amount": -20.0000,
                          "date": "2025-06-30T15:22:05"
                        },
                        {
                          "amount": 15.0000,
                          "date": "2025-05-30T11:34:15"
                        },
                        {
                          "amount": 55.0000,
                          "date": "2025-04-30T12:44:01"
                        },
                        {
                          "amount": -100.0000,
                          "date": "2025-03-23T12:40:32"
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
            ),
            new Response(
                body: <<<'JSON'
                    {
                      "data": [
                        {
                          "amount": 55.0000,
                          "date": "2025-04-30T12:44:01"
                        },
                        {
                          "amount": 15.0000,
                          "date": "2025-05-30T11:34:15"
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
            ),
            new Response(
                body: <<<'JSON'
                    {
                      "data": [
                        {
                          "amount": -100.0000,
                          "date": "2025-03-23T12:40:32"
                        },
                        {
                          "amount": -20.0000,
                          "date": "2025-06-30T15:22:05"
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
            ),
        ];

        $loymax = $this->createLoymaxClient($mockResponseList);

        /**
         * Дата после
         */
        $result = $loymax->publicApi('validAccessToken')->user()->getDetailedBalanceOperations(
            currencyId: 1,
            fromDate: new DateTimeImmutable('2025-06-01'),
        );

        self::assertCount(1, $result);

        self::assertSame(-20.0000, $result[0]->amount);
        self::assertSame('2025-06-30T15:22:05+00:00', $result[0]->date->format(DateTimeInterface::ATOM));

        /**
         * Дата до
         */
        $result = $loymax->publicApi('validAccessToken')->user()->getDetailedBalanceOperations(
            currencyId: 1,
            toDate: new DateTimeImmutable('2025-04-01'),
        );

        self::assertCount(1, $result);

        self::assertSame(-100.0000, $result[0]->amount);
        self::assertSame('2025-03-23T12:40:32+00:00', $result[0]->date->format(DateTimeInterface::ATOM));

        /**
         * Указан период
         */
        $result = $loymax->publicApi('validAccessToken')->user()->getDetailedBalanceOperations(
            currencyId: 1,
            fromDate: new DateTimeImmutable('2025-04-01'),
            toDate: new DateTimeImmutable('2025-05-01'),
        );

        self::assertCount(1, $result);

        self::assertSame(55.0000, $result[0]->amount);
        self::assertSame('2025-04-30T12:44:01+00:00', $result[0]->date->format(DateTimeInterface::ATOM));

        /**
         * Сортирока по дате по возрастанию
         */
        $result = $loymax->publicApi('validAccessToken')->user()->getDetailedBalanceOperations(
            currencyId: 1,
            orderByDateAscending: false,
        );

        self::assertCount(4, $result);

        self::assertSame(-20.0000, $result[0]->amount);
        self::assertSame('2025-06-30T15:22:05+00:00', $result[0]->date->format(DateTimeInterface::ATOM));
        self::assertSame(15.0000, $result[1]->amount);
        self::assertSame('2025-05-30T11:34:15+00:00', $result[1]->date->format(DateTimeInterface::ATOM));
        self::assertSame(55.0000, $result[2]->amount);
        self::assertSame('2025-04-30T12:44:01+00:00', $result[2]->date->format(DateTimeInterface::ATOM));
        self::assertSame(-100.0000, $result[3]->amount);
        self::assertSame('2025-03-23T12:40:32+00:00', $result[3]->date->format(DateTimeInterface::ATOM));

        /**
         * Только активация
         */
        $result = $loymax->publicApi('validAccessToken')->user()->getDetailedBalanceOperations(
            currencyId: 1,
            changeTypes: DetailedBalanceOperationType::BonusActivation,
        );

        self::assertCount(2, $result);

        self::assertSame(55.0000, $result[0]->amount);
        self::assertSame('2025-04-30T12:44:01+00:00', $result[0]->date->format(DateTimeInterface::ATOM));
        self::assertSame(15.0000, $result[1]->amount);
        self::assertSame('2025-05-30T11:34:15+00:00', $result[1]->date->format(DateTimeInterface::ATOM));

        /**
         * Только сгорания
         */
        $result = $loymax->publicApi('validAccessToken')->user()->getDetailedBalanceOperations(
            currencyId: 1,
            changeTypes: DetailedBalanceOperationType::BonusExpiration,
        );

        self::assertCount(2, $result);

        self::assertSame(-100.0000, $result[0]->amount);
        self::assertSame('2025-03-23T12:40:32+00:00', $result[0]->date->format(DateTimeInterface::ATOM));
        self::assertSame(-20.0000, $result[1]->amount);
        self::assertSame('2025-06-30T15:22:05+00:00', $result[1]->date->format(DateTimeInterface::ATOM));
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
        $loymax->publicApi()->user()->getDetailedBalanceOperations(1);
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
        $loymax->publicApi('validAccessToken')->user()->getDetailedBalanceOperations(1);
    }

    #[TestDox('Некорректные даты')]
    public function testInvalidDates(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $loymax = $this->createLoymaxClient();
        $loymax->publicApi('validAccessToken')->user()->getDetailedBalanceOperations(
            currencyId: 1,
            fromDate: new DateTimeImmutable('1 day'),
            toDate: new DateTimeImmutable('1 day ago'),
        );
    }
}
