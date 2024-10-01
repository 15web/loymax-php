<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\PublicApi\Exception\DenormalizeResponseError;
use Studio15\Loymax\PublicApi\User\Request\GetSubscriptionRequest;
use Studio15\Loymax\PublicApi\User\Response\Subscription;
use Studio15\Loymax\PublicApi\User\Response\SubscriptionExternalId;
use Throwable;

/**
 * Возвращает список подписок клиента
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/Subscriptions/#H41243E43743244043044943043544244143F43844143E43A43F43E43443F43844143E43A43A43B43843543D442430
 *
 * @internal
 */
final readonly class GetSubscriptions
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @return list<Subscription>
     *
     * @throws DenormalizeResponseError
     */
    public function __invoke(GetSubscriptionRequest $request): array
    {
        $apiRequest = (new CreateRequest())(
            method: Method::GET,
            uri: '/publicapi/v1.2/User/Subscriptions',
            parameters: [
                'subscriptionExternalIds[]' => array_map(
                    static fn (SubscriptionExternalId $externalId): string => $externalId->value,
                    $request->subscriptionExternalIds,
                ),
            ],
        );

        $apiResponse = $this->apiClient->sendRequest($apiRequest);

        try {
            /** @var list<Subscription> $subscriptionList */
            $subscriptionList = (new CreateSerializer())()->denormalize(
                data: $apiResponse->data ?? [],
                type: Subscription::class.'[]',
            );
        } catch (Throwable $e) {
            throw new DenormalizeResponseError(previous: $e);
        }

        return $subscriptionList;
    }
}
