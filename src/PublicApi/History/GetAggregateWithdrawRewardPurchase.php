<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\History;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Exception\DenormalizeResponseError;
use Studio15\Loymax\PublicApi\History\Request\GetAggregateWithdrawRewardPurchaseRequest;
use Studio15\Loymax\PublicApi\History\Response\AggregatedOperations;
use Throwable;

/**
 * Возвращает сумму покупок, сумму начисленных и списанных бонусов в рамках покупок
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/History/#H41243E43743244043044943043544244144343C43C44343F43E43A44343F43E43A2C44144343C43C44343D43044743844143B43543D43D44B44543844143F43844143043D43D44B44543143E43D44344143E43243244043043C43A43044543F43E43A44343F43E43A
 */
final readonly class GetAggregateWithdrawRewardPurchase
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(GetAggregateWithdrawRewardPurchaseRequest $request): AggregatedOperations
    {
        $parameters = [
            'filter.fromDate' => $request->fromDate?->format('c'),
            'filter.toDate' => $request->toDate?->format('c'),
        ];

        $apiRequest = (new CreateRequest())(
            method: Method::GET,
            uri: '/publicapi/v1.2/History/AggregateWithdrawRewardPurchase',
            parameters: $parameters,
        );

        $apiResponse = $this->apiClient->sendRequest($apiRequest);

        try {
            /** @var AggregatedOperations $aggregatedOperations */
            $aggregatedOperations = (new CreateSerializer())()->denormalize(
                data: $apiResponse->data ?? [],
                type: AggregatedOperations::class,
            );
        } catch (Throwable $e) {
            throw new DenormalizeResponseError(previous: $e);
        }

        return $aggregatedOperations;
    }
}
