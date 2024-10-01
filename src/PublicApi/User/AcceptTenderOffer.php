<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\Data\Method;

/**
 * Оформляет принятие оферты
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/#11
 *
 * @internal
 */
final readonly class AcceptTenderOffer
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    public function __invoke(): void
    {
        $request = (new CreateRequest())(
            method: Method::POST,
            uri: '/publicapi/v1.2/User/AcceptTenderOffer',
        );

        $this->apiClient->sendRequest($request);
    }
}
