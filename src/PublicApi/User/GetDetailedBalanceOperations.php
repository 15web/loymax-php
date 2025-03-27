<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User;

use DateTimeInterface;
use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Data\Pagination;
use Studio15\Loymax\PublicApi\User\Request\GetDetailedBalanceOperationsRequest;
use Studio15\Loymax\PublicApi\User\Response\LifeTimesByTime;

/**
 * Возвращает информацию обо всех операциях активации и сгораниях по конкретному счету клиента
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/#12
 */
final readonly class GetDetailedBalanceOperations
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @param positive-int $currencyId
     *
     * @return list<LifeTimesByTime>
     *
     * @throws ApiClientException
     */
    public function __invoke(int $currencyId, GetDetailedBalanceOperationsRequest $request, Pagination $pagination): array
    {
        $parameters = [
            'orderByDateAscending' => $request->orderByDateAscending === true ? 'true' : 'false',
            'filter.fromDate' => $request->fromDate?->format(DateTimeInterface::ATOM),
            'filter.toDate' => $request->toDate?->format(DateTimeInterface::ATOM),
            'filter.changeTypes' => $request->changeTypes?->value,
            'from' => $pagination->from,
            'count' => $pagination->count,
        ];

        $apiRequest = (new CreateRequest())(
            method: Method::GET,
            uri: "/publicapi/v1.2/User/DetailedBalance/{$currencyId}/Operations",
            parameters: $parameters,
        );

        $apiResponse = $this->apiClient->sendRequest($apiRequest);

        /** @var list<LifeTimesByTime> $operationsList */
        $operationsList = (new CreateSerializer())()->denormalize(
            data: $apiResponse->data ?? [],
            type: LifeTimesByTime::class.'[]',
        );

        return $operationsList;
    }
}
