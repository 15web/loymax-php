<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\User\SendAnswers;

use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\PublicApi\User\Request\Answer;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Обновление ответов на вопросы анкеты')]
final class SendAnswersTest extends TestCase
{
    #[TestDox('Успешный результат')]
    public function testSucceed(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
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

        $answers = [
            new Answer(
                questionId: 1,
                questionGroupId: 1,
                value: 'answer1',
            ),
            new Answer(
                questionId: 2,
                questionGroupId: 1,
                value: 'answer2',
            ),
        ];

        $result = $loymax->publicApi('validAccessToken')
            ->user()
            ->sendAnswers($answers);

        self::assertSame([], $result->errors);
    }

    #[TestDox('Ответы содержат ошибки')]
    public function testIncorrectAnswers(): void
    {
        $mockResponse = new Response(
            body: <<<'JSON'
                {
                  "data": {
                    "errors": [
                      {
                        "idQuestion": "1",
                        "errors": [
                          "Error1",
                          "Error2"
                        ]
                      },
                      {
                        "idQuestion": "2",
                        "errors": [
                          "Error3"
                        ]
                      }
                    ]
                  },
                  "result": {
                    "state": "Error",
                    "message": null,
                    "messageCode": null,
                    "exception": null,
                    "validationErrors": null
                  }
                }
                JSON,
        );

        $loymax = $this->createLoymaxClient([$mockResponse]);

        $answers = [
            new Answer(
                questionId: 1,
                questionGroupId: 1,
                value: 'answer1',
            ),
            new Answer(
                questionId: 2,
                questionGroupId: 1,
                value: 'answer2',
            ),
        ];

        $result = $loymax->publicApi('validAccessToken')
            ->user()
            ->sendAnswers($answers);

        self::assertCount(2, $result->errors);
        self::assertSame('1', $result->errors[0]->idQuestion);
        self::assertSame('Error1', $result->errors[0]->errors[0]);
        self::assertSame('Error2', $result->errors[0]->errors[1]);
        self::assertSame('2', $result->errors[1]->idQuestion);
        self::assertSame('Error3', $result->errors[1]->errors[0]);
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

        $answers = [
            new Answer(
                questionId: 1,
                questionGroupId: 1,
                value: 'answer1',
            ),
        ];

        $loymax->publicApi()
            ->user()
            ->sendAnswers($answers);
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

        $answers = [
            new Answer(
                questionId: 1,
                questionGroupId: 1,
                value: 'answer1',
            ),
        ];

        $loymax->publicApi()
            ->user()
            ->sendAnswers($answers);
    }

    #[TestDox('Пустой список вопросов')]
    public function testInvalidAnswerRequestData(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $loymax = $this->createLoymaxClient();
        $loymax->publicApi()
            ->user()
            ->sendAnswers([]);
    }
}
