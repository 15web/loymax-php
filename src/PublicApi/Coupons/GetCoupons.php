<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Coupons;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Coupons\Request\GetCouponsRequest;
use Studio15\Loymax\PublicApi\Coupons\Response\Coupon;

/**
 * Возвращает список купонов
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Coupons/#03
 */
final readonly class GetCoupons
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @return list<Coupon>
     *
     * @throws ApiClientException
     */
    public function __invoke(GetCouponsRequest $parameters): array
    {
        $apiResponse = $this->apiClient->sendRequest(
            method: Method::GET,
            uri: '/publicapi/v1.2/Coupons',
            parameters: $parameters,
        );

        /** @var list<Coupon> $coupon */
        $coupon = (new CreateSerializer())()->denormalize(
            data: $apiResponse->data ?? [],
            type: Coupon::class.'[]',
        );

        return $coupon;
    }
}
