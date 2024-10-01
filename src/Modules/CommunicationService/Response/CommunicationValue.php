<?php

declare(strict_types=1);

namespace Studio15\Loymax\Modules\CommunicationService\Response;

use DateTimeImmutable;

/**
 * Информация о товаре в персональном предложении
 */
final readonly class CommunicationValue
{
    /**
     * @param DateTimeImmutable $dateFrom Дата начала действия персонального предложения
     * @param DateTimeImmutable $dateTo Дата окончания действия персонального предложения
     * @param non-empty-string $goodsId Код товара
     * @param non-empty-string $name Название товара
     * @param non-empty-string|null $categoryName Категория товара
     * @param list<Image> $images Информация об изображении товара
     * @param non-empty-string $description Описание товара
     * @param positive-int|null $regularPrice Цена товара (без учета преференций)
     * @param non-empty-string|null $regularPriceDescription Описание цены
     * @param list<Offer> $offers Условия предложения
     */
    public function __construct(
        public DateTimeImmutable $dateFrom,
        public DateTimeImmutable $dateTo,
        public string $goodsId,
        public string $name,
        public ?string $categoryName,
        public array $images,
        public string $description,
        public ?int $regularPrice,
        public ?string $regularPriceDescription,
        public array $offers,
    ) {}
}
