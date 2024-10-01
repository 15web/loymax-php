<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Exception\DenormalizeResponseError;
use Studio15\Loymax\PublicApi\User\Response\Balance;
use Throwable;

/**
 * Возвращает информацию о балансе клиента
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/#04
 */
final readonly class GetBalance
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @return list<Balance>
     *
     * @throws ApiClientException
     */
    public function __invoke(): array
    {
        $apiRequest = (new CreateRequest())(
            method: Method::GET,
            uri: '/publicapi/v1.2/User/Balance',
        );

        $apiResponse = $this->apiClient->sendRequest($apiRequest);

        try {
            /** @var list<Balance> $balanceList */
            $balanceList = (new CreateSerializer())()->denormalize(
                data: $apiResponse->data ?? [],
                type: Balance::class.'[]',
            );
        } catch (Throwable $e) {
            throw new DenormalizeResponseError(previous: $e);
        }

        return $balanceList;
    }
}
