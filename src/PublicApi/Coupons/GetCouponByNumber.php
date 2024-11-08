<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Coupons;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Coupons\Response\Coupon;
use Webmozart\Assert\Assert;

/**
 * Возвращает информацию о купоне по номеру
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Coupons/#02
 */
final readonly class GetCouponByNumber
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @param non-empty-string $couponNumber Номер купона
     *
     * @throws ApiClientException
     */
    public function __invoke(string $couponNumber): Coupon
    {
        Assert::stringNotEmpty($couponNumber);

        $apiRequest = (new CreateRequest())(
            method: Method::GET,
            uri: "/publicapi/v1.2/Coupons/number/{$couponNumber}",
        );

        $apiResponse = $this->apiClient->sendRequest($apiRequest);

        /** @var Coupon $coupon */
        $coupon = (new CreateSerializer())()->denormalize(
            data: $apiResponse->data ?? [],
            type: Coupon::class,
        );

        return $coupon;
    }
}
