<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Coupons;

use DateTimeImmutable;
use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Coupons\Request\GetCouponsRequest;
use Studio15\Loymax\PublicApi\Coupons\Response\Coupon;
use Studio15\Loymax\PublicApi\Data\Pagination;

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
    public function __invoke(GetCouponsRequest $request, Pagination $pagination): array
    {
        $parameters = [
            'from' => $pagination->from,
            'count' => $pagination->count,
        ];

        if ($request->emissionIds !== []) {
            $parameters['couponListFilter.emissionIds'] = $request->emissionIds;
        }

        $couponStates = $request->getCouponStatesValues();
        if ($couponStates !== []) {
            $parameters['couponListFilter.couponStates'] = $couponStates;
        }

        if ($request->changedStateDateFrom !== null) {
            $parameters['couponListFilter.changedStateDateFrom'] = $request->changedStateDateFrom->format(DateTimeImmutable::ATOM);
        }

        if ($request->changedStateDateTo !== null) {
            $parameters['couponListFilter.changedStateDateTo'] = $request->changedStateDateTo->format(DateTimeImmutable::ATOM);
        }

        if ($request->couponNumber !== null) {
            $parameters['couponListFilter.couponNumber'] = $request->couponNumber;
        }

        $apiRequest = (new CreateRequest())(
            method: Method::GET,
            uri: '/publicapi/v1.2/Coupons',
            parameters: $parameters,
        );

        $apiResponse = $this->apiClient->sendRequest($apiRequest);

        /** @var list<Coupon> $coupon */
        $coupon = (new CreateSerializer())()->denormalize(
            data: $apiResponse->data ?? [],
            type: Coupon::class.'[]',
        );

        return $coupon;
    }
}
