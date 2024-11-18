<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Coupons\Request;

use DateTimeImmutable;
use Studio15\Loymax\PublicApi\Coupons\Response\CouponState;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Webmozart\Assert\Assert;

/**
 * Фильтр для получения списка купонов по заданным параметрам выборки
 *
 * @internal
 *
 * @api
 */
final readonly class GetCouponsRequest
{
    /**
     * @param list<positive-int> $emissionIds Внутренний идентификатор выпуска купонов, по которому должна производиться выборка
     * @param list<CouponState> $couponStates Статус купонов, по которым должна производиться выборка: Created — создан, Issued — выдан, Used — погашен, Rejected — отозван, QueuedToUse — в очереди на гашение, QueuedToIssue — в очереди на выдачу, Expired — истек
     * @param DateTimeImmutable|null $changedStateDateFrom Дата начала периода, в который последний раз был изменен статус купона
     * @param DateTimeImmutable|null $changedStateDateTo Дата окончания периода, в который последний раз был изменен статус купона
     * @param non-empty-string|null $couponNumber Номер купона
     * @param non-negative-int $from Порядковый номер начального элемента выборки
     * @param positive-int $count Количество возвращаемых элементов выборки
     */
    public function __construct(
        #[SerializedName('couponListFilter.emissionIds')]
        public array $emissionIds,
        #[SerializedName('couponListFilter.couponStates')]
        public array $couponStates,
        #[SerializedName('couponListFilter.changedStateDateFrom')]
        public ?DateTimeImmutable $changedStateDateFrom,
        #[SerializedName('couponListFilter.changedStateDateTo')]
        public ?DateTimeImmutable $changedStateDateTo,
        #[SerializedName('couponListFilter.couponNumber')]
        public ?string $couponNumber,
        public int $from,
        public int $count,
    ) {
        if ($this->changedStateDateTo !== null && $this->changedStateDateFrom !== null) {
            Assert::greaterThan($this->changedStateDateTo, $this->changedStateDateFrom);
        }

        Assert::natural($this->from);
        Assert::positiveInteger($this->count);
    }
}
