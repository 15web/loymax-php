<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi;

use DateTimeImmutable;
use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Coupons\GetCouponByNumber;
use Studio15\Loymax\PublicApi\Coupons\GetCoupons;
use Studio15\Loymax\PublicApi\Coupons\Request\GetCouponsRequest;
use Studio15\Loymax\PublicApi\Coupons\Response\Coupon;
use Studio15\Loymax\PublicApi\Coupons\Response\CouponState;

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
     * Возвращает список купонов
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Coupons/#03
     *
     * @param list<positive-int> $emissionIds Внутренний идентификатор выпуска купонов, по которому должна производиться выборка
     * @param list<CouponState> $couponStates Статус купонов, по которым должна производиться выборка: Created — создан, Issued — выдан, Used — погашен, Rejected — отозван, QueuedToUse — в очереди на гашение, QueuedToIssue — в очереди на выдачу, Expired — истек
     * @param DateTimeImmutable|null $changedStateDateFrom Дата начала периода, в который последний раз был изменен статус купона
     * @param DateTimeImmutable|null $changedStateDateTo Дата окончания периода, в который последний раз был изменен статус купона
     * @param non-empty-string|null $couponNumber Номер купона
     * @param non-negative-int $from Порядковый номер начального элемента выборки
     * @param positive-int $count Количество возвращаемых элементов выборки
     *
     * @return list<Coupon>
     *
     * @throws ApiClientException
     */
    public function getCoupons(
        array $emissionIds = [],
        array $couponStates = [],
        ?DateTimeImmutable $changedStateDateFrom = null,
        ?DateTimeImmutable $changedStateDateTo = null,
        ?string $couponNumber = null,
        int $from = 0,
        int $count = 10,
    ): array {
        $parameters = new GetCouponsRequest(
            emissionIds: $emissionIds,
            couponStates: $couponStates,
            changedStateDateFrom: $changedStateDateFrom,
            changedStateDateTo: $changedStateDateTo,
            couponNumber: $couponNumber,
            from: $from,
            count: $count,
        );

        $getCoupons = new GetCoupons(
            apiClient: $this->apiClient,
        );

        return ($getCoupons)(
            parameters: $parameters,
        );
    }

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
