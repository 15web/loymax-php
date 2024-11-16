<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
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

        $apiResponse = $this->apiClient->sendRequest(
            method: Method::POST,
            uri: '/publicapi/v1.2/User/Answers',
            body: $answers,
        );

        /** @var AnswerErrors $answersResult */
        $answersResult = (new CreateSerializer())()->denormalize(
            data: $apiResponse->data ?? [],
            type: AnswerErrors::class,
        );

        return $answersResult;
    }
}
