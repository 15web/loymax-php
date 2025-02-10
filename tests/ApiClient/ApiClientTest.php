<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\ApiClient;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use Psr\Log\NullLogger;
use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\BadRequest;
use Studio15\Loymax\ApiClient\Exception\DeserializeResponseError;
use Studio15\Loymax\ApiClient\Exception\Forbidden;
use Studio15\Loymax\ApiClient\Exception\InvalidRequest;
use Studio15\Loymax\ApiClient\Exception\MethodNotAllowed;
use Studio15\Loymax\ApiClient\Exception\NotFound;
use Studio15\Loymax\ApiClient\Exception\UnknownErrorException;
use Studio15\Loymax\ApiClient\Response\ValidationError;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('API клиент')]
final class ApiClientTest extends TestCase
{
    #[TestDox('Ошибка транспорта')]
    public function testRequestException(): void
    {
        $this->expectException(UnknownErrorException::class);

        $mock = new MockHandler([
            new RequestException(
                message: 'Ошибка подключения к серверу',
                request: new Request(method: 'GET', uri: 'test'),
            ),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $httpClient = new Client(['handler' => $handlerStack]);

        $apiClient = new ApiClient(
            httpClient: $httpClient,
            logger: new NullLogger(),
        );

        $request = (new CreateRequest())(
            method: Method::GET,
            uri: 'test',
        );

        $apiClient->sendRequest($request);
    }

    #[TestDox('Пустой результат')]
    public function testNullResult(): void
    {
        // нет поля result
        $mock = new MockHandler([
            new Response(
                status: 200,
                body: <<<'JSON'
                    {
                      "data": "test"
                    }
                    JSON,
            ),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $httpClient = new Client(['handler' => $handlerStack]);

        $apiClient = new ApiClient(
            httpClient: $httpClient,
            logger: new NullLogger(),
        );

        $request = (new CreateRequest())(
            method: Method::GET,
            uri: 'test',
        );

        $result = $apiClient->sendRequest($request);

        self::assertSame('test', $result->data);
    }

    #[TestDox('Ошибки валидации')]
    public function testValidationError(): void
    {
        $this->expectExceptionObject(
            new InvalidRequest([
                new ValidationError(
                    field: 'validatedField',
                    errorMessages: ['validationError1', 'validationError2'],
                ),
            ]),
        );

        $this->expectExceptionMessage('Ошибка валидации');

        $mock = new MockHandler([
            new Response(
                status: 200,
                body: <<<'JSON'
                    {
                      "data": [],
                      "result": {
                        "state": "ValidationError",
                        "httpCode": 400,
                        "message": null,
                        "messageCode": null,
                        "exception": null,
                        "validationErrors": [
                          {
                            "field": "validatedField",
                            "errorMessages": ["validationError1", "validationError2"]
                          }
                        ]
                      }
                    }
                    JSON,
            ),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $httpClient = new Client(['handler' => $handlerStack]);

        $apiClient = new ApiClient(
            httpClient: $httpClient,
            logger: new NullLogger(),
        );

        $request = (new CreateRequest())(
            method: Method::GET,
            uri: 'test',
        );

        $apiClient->sendRequest($request);
    }

    /**
     * @param array{0: class-string<Exception>, 1: Response} $data
     */
    #[DataProvider('httpErrors')]
    #[TestDox('Статусы при ошибках')]
    public function testHttpErrors(array $data): void
    {
        $this->expectException($data[0]);

        $handlerStack = HandlerStack::create(
            handler: new MockHandler([$data[1]]),
        );
        $httpClient = new Client(config: [
            'handler' => $handlerStack,
        ]);

        $apiClient = new ApiClient(
            httpClient: $httpClient,
            logger: new NullLogger(),
        );

        $request = (new CreateRequest())(
            method: Method::GET,
            uri: 'test',
        );

        $apiClient->sendRequest($request);
    }

    public static function httpErrors(): Iterator
    {
        yield 'Некорректный формат ответа' => [[DeserializeResponseError::class, new Response()]];

        yield 'Некорректный запрос' => [
            [
                BadRequest::class,
                new Response(
                    status: 400,
                    body: <<<'JSON'
                        {
                          "error": "Error",
                          "error_description":"ErrorDescription"
                        }
                        JSON,
                ),
            ],
        ];

        yield 'Доступ запрещен' => [[Forbidden::class, new Response(status: 403)]];

        yield 'Метод API не найден' => [[NotFound::class, new Response(status: 404)]];

        yield 'Некорректный метод запроса' => [[MethodNotAllowed::class, new Response(status: 405)]];

        yield 'Ошибка сервера' => [[UnknownErrorException::class, new Response(status: 500)]];
    }
}
