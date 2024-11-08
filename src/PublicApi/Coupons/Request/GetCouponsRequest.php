<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Coupons\Request;

use DateTimeImmutable;
use Studio15\Loymax\PublicApi\Coupons\Response\CouponState;

/**
 * Фильтр для получения списка купонов по заданным параметрам выборки
 *
 * @internal
 */
final readonly class GetCouponsRequest
{
    /**
     * @param list<positive-int> $emissionIds Внутренний идентификатор выпуска купонов, по которому должна производиться выборка
     * @param list<CouponState> $couponStates Статус купонов, по которым должна производиться выборка: Created — создан, Issued — выдан, Used — погашен, Rejected — отозван, QueuedToUse — в очереди на гашение, QueuedToIssue — в очереди на выдачу, Expired — истек
     * @param DateTimeImmutable|null $changedStateDateFrom Дата начала периода, в который последний раз был изменен статус купона
     * @param DateTimeImmutable|null $changedStateDateTo Дата окончания периода, в который последний раз был изменен статус купона
     * @param non-empty-string|null $couponNumber Номер купона
     */
    public function __construct(
        public array $emissionIds,
        public array $couponStates,
        public ?DateTimeImmutable $changedStateDateFrom,
        public ?DateTimeImmutable $changedStateDateTo,
        public ?string $couponNumber,
    ) {}

    /**
     * @return list<non-empty-string>
     */
    public function getCouponStatesValues(): array
    {
        if ($this->couponStates === []) {
            return [];
        }

        return array_map(
            callback: static fn (CouponState $couponState): string => $couponState->value,
            array: $this->couponStates,
        );
    }
}
