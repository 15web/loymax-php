<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Coupons\Response;

use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

/**
 * @api
 * Купон
 */
final readonly class Coupon
{
    /**
     * @param positive-int $id Внутренний идентификатор купона
     * @param non-empty-string $code Номер купона
     * @param non-empty-string $qrContent QR-код
     * @param DateTimeImmutable $createDate Дата создания купона
     * @param DateTimeImmutable $updateDate Дата последнего изменения состояния купона
     * @param DateTimeImmutable $activationDate Дата активации купона
     * @param DateTimeImmutable|null $expiryDate Дата истечения купона
     * @param CouponState $couponState Состояние купона
     * @param non-empty-string $emissionTitle Название выпуска купонов
     * @param positive-int $emissionId Внутренний идентификатор выпуска купонов
     * @param Uuid $emissionUid Внешний идентификатор выпуска купонов
     * @param non-empty-string|null $shortDescription Короткое описание выпуска купонов
     * @param non-empty-string|null $description Описание выпуска купонов
     * @param Image|null $imageFile Изображение купона
     */
    public function __construct(
        public int $id,
        public string $code,
        public string $qrContent,
        public DateTimeImmutable $createDate,
        public DateTimeImmutable $updateDate,
        public DateTimeImmutable $activationDate,
        public ?DateTimeImmutable $expiryDate,
        public CouponState $couponState,
        public string $emissionTitle,
        public int $emissionId,
        public Uuid $emissionUid,
        public ?string $shortDescription,
        public ?string $description,
        public ?Image $imageFile,
    ) {}
}
