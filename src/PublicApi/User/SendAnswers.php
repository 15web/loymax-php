<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\PublicApi\User\Request\Answer;
use Studio15\Loymax\PublicApi\User\Response\AnswerErrors;
use Webmozart\Assert\Assert;

/**
 * Обновление ответов на вопросы анкеты
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/#10
 */
final readonly class SendAnswers
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @param list<Answer> $answers
     *
     * @throws ApiClientException
     */
    public function __invoke(array $answers): AnswerErrors
    {
        Assert::notEmpty($answers);

        /** @var non-empty-list<array{array-key, mixed}> $answerList */
        $answerList = (new CreateSerializer())()->normalize(
            data: $answers,
        );

        $apiRequest = (new CreateRequest())(
            method: Method::POST,
            uri: '/publicapi/v1.2/User/Answers',
            body: $answerList,
        );

        try {
            $apiResponse = $this->apiClient->sendRequest($apiRequest);

            /** @var array<array-key, mixed>|null $responseData */
            $responseData = $apiResponse->data;
        } catch (InvalidResponse $exception) {
            /** @var array{errors?: mixed}|null $responseData */
            $responseData = $exception->data;

            /*
             * Если в теле ответа есть свойство errors,
             * значит есть ошибки валидации ответов анкеты.
             * Иначе запрос завершился с иной ошибкой.
             */
            $responseData['errors'] ?? throw $exception;
        }

        /** @var AnswerErrors $answersResult */
        $answersResult = (new CreateSerializer())()->denormalize(
            data: $responseData ?? [],
            type: AnswerErrors::class,
        );

        return $answersResult;
    }
}
