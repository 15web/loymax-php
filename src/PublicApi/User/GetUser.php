<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\User\Request\GetUserPayload;
use Studio15\Loymax\PublicApi\User\Request\GetUserRequest;
use Studio15\Loymax\PublicApi\User\Response\User;
use Webmozart\Assert\Assert;

/**
 * Возвращает информацию о клиенте
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/#01
 */
final readonly class GetUser
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(GetUserRequest $parameters): User
    {
        $this->validatePayload($parameters->payload);

        $apiResponse = $this->apiClient->sendRequest(
            method: Method::GET,
            uri: '/publicapi/v1.2/User',
            parameters: $parameters,
        );

        /** @var User $user */
        $user = (new CreateSerializer())()->denormalize(
            data: $apiResponse->data ?? [],
            type: User::class,
        );

        return $user;
    }

    /**
     * @param list<GetUserPayload|non-empty-string> $payload
     */
    private function validatePayload(array $payload = []): void
    {
        foreach ($payload as $value) {
            if ($value instanceof GetUserPayload) {
                continue;
            }

            Assert::startsWith($value, 'Attributes.');
        }
    }
}
