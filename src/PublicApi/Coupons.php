<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Coupons\GetCouponByNumber;
use Studio15\Loymax\PublicApi\Coupons\Response\Coupon;

/**
 * Coupons. Методы для работы с купонами
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Coupons/
 */
final readonly class Coupons
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * Возвращает информацию о купоне по номеру
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Coupons/#02
     *
     * @param non-empty-string $couponNumber Номер купона
     *
     * @throws ApiClientException
     */
    public function getCouponByNumber(string $couponNumber): Coupon
    {
        $getCouponByNumber = new GetCouponByNumber(
            apiClient: $this->apiClient,
        );

        return ($getCouponByNumber)(
            couponNumber: $couponNumber,
        );
    }
}
