<?php

declare(strict_types=1);

namespace Studio15\Loymax\Modules\CommunicationService\Response;

/**
 * Предложение
 */
final readonly class Offer
{
    /**
     * @param float $value Размер преференции (процент, фиксированная цена и т. д.)
     * @param non-empty-string|null $valueDescription Описание преференции
     * @param float|null $border Минимальная сумма чека/товара для действия преференций
     * @param non-empty-string|null $borderDescription Описание минимальной суммы
     * @param positive-int $displayOrder Порядок приоритета товара
     * @param OfferType $offerType Тип преференции
     * @param non-empty-string|null $description Описание преференции
     */
    public function __construct(
        public float $value,
        public ?string $valueDescription,
        public ?float $border,
        public ?string $borderDescription,
        public int $displayOrder,
        public OfferType $offerType,
        public ?string $description,
    ) {}
}
