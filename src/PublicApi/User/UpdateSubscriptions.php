<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\PublicApi\User\Response\UpdatedSubscription;

/**
 * Обновляет информацию о подписках клиента
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/Subscriptions/#H41E43143D43E43243B44F435442A043843D44443E44043C43044643844E43E43F43E43443F43844143A43044543A43B43843543D442430
 */
final readonly class UpdateSubscriptions
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @param non-empty-list<UpdatedSubscription> $updatingSubscriptions
     */
    public function __invoke(array $updatingSubscriptions): void
    {
        $apiRequest = (new CreateRequest())(
            method: Method::POST,
            uri: '/publicapi/v1.2/User/Subscriptions',
            body: $updatingSubscriptions,
        );

        $this->apiClient->sendRequest($apiRequest);
    }
}
