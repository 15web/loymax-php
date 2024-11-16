<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;

/**
 * Оформляет отказ от всех типов подписок
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/Subscriptions/#H41E44443E44043C43B44F43544243E44243A43043743E44243244143544544243843F43E43243F43E43443F43844143E43A
 */
final readonly class RejectSubscriptions
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
            uri: '/publicapi/v1.2/User/Subscriptions/Reject',
        );
    }
}
