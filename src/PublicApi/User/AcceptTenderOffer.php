<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;

/**
 * Оформляет принятие оферты
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/#11
 */
final readonly class AcceptTenderOffer
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(): void
    {
        $this->apiClient->sendRequest(
            method: Method::POST,
            uri: '/publicapi/v1.2/User/AcceptTenderOffer',
        );
    }
}
