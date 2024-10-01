<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\PublicApi\Exception\DenormalizeResponseError;
use Studio15\Loymax\PublicApi\User\Request\GetUserPayload;
use Studio15\Loymax\PublicApi\User\Response\User;
use Throwable;
use Webmozart\Assert\Assert;

/**
 * Возвращает информацию о клиенте
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/#01
 *
 * @internal
 */
final readonly class GetUser
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @param list<GetUserPayload|non-empty-string> $payload
     *
     * @throws DenormalizeResponseError
     */
    public function __invoke(array $payload = []): User
    {
        $this->validatePayload($payload);

        $apiRequest = (new CreateRequest())(
            method: Method::GET,
            uri: '/publicapi/v1.2/User',
            parameters: [
                'payload' => $payload,
            ],
        );

        $apiResponse = $this->apiClient->sendRequest($apiRequest);

        try {
            /** @var User $user */
            $user = (new CreateSerializer())()->denormalize(
                data: $apiResponse->data ?? [],
                type: User::class,
            );
        } catch (Throwable $e) {
            throw new DenormalizeResponseError(previous: $e);
        }

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
