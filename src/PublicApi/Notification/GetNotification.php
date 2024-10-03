<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Notification;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Data\Pagination;
use Studio15\Loymax\PublicApi\Notification\Response\Notification;

/**
 * Возвращает список оповещений
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Notification/#H41243E43743244043044943043544244143F43844143E43AA043E43F43E43243544943543D438439
 */
final readonly class GetNotification
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @return list<Notification>
     *
     * @throws ApiClientException
     */
    public function __invoke(Pagination $pagination): array
    {
        $parameters = [
            'from' => $pagination->from,
            'count' => $pagination->count,
        ];

        $apiRequest = (new CreateRequest())(
            method: Method::GET,
            uri: '/publicapi/v1.2/Notification',
            parameters: $parameters,
        );

        $apiResponse = $this->apiClient->sendRequest($apiRequest);

        /** @var list<Notification> $notificationList */
        $notificationList = (new CreateSerializer())()->denormalize(
            data: $apiResponse->data ?? [],
            type: Notification::class.'[]',
        );

        return $notificationList;
    }
}
