<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\PublicApi\Exception\DenormalizeResponseError;
use Studio15\Loymax\PublicApi\User\Response\DetailedBalance;
use Throwable;

/**
 * Возвращает информацию о детализированном балансе клиента
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/#08
 */
final readonly class GetDetailedBalance
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @return list<DetailedBalance>
     */
    public function __invoke(): array
    {
        $apiRequest = (new CreateRequest())(
            method: Method::GET,
            uri: '/publicapi/v1.2/User/DetailedBalance',
        );

        $apiResponse = $this->apiClient->sendRequest($apiRequest);

        /**
         * @var array{items?: array<array-key, mixed>} $data
         */
        $data = $apiResponse->data ?? [];

        try {
            /** @var list<DetailedBalance> $detailedBalanceList */
            $detailedBalanceList = (new CreateSerializer())()->denormalize(
                data: $data['items'] ?? [],
                type: DetailedBalance::class.'[]',
            );
        } catch (Throwable $e) {
            throw new DenormalizeResponseError(previous: $e);
        }

        return $detailedBalanceList;
    }
}
