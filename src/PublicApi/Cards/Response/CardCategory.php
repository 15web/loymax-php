<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards\Response;

use Symfony\Component\Serializer\Attribute\SerializedName;

/**
 * @api
 * Описание категории карты
 */
final readonly class CardCategory
{
    /**
     * @param positive-int $id Внутренний идентификатор категории карты в Системе
     * @param non-empty-string $type
     * @param non-empty-string $title Название категории карты
     * @param non-empty-string $logicalName Логическое имя категории карты
     * @param non-empty-string|null $description Описание категории карты
     * @param non-negative-int $cardCount Количество карт в категории
     * @param list<CardCategoryImage> $images Изображение карты соответствующей категории
     */
    public function __construct(
        public int $id,
        #[SerializedName('$type')]
        public string $type,
        public string $title,
        public string $logicalName,
        public ?string $description,
        public int $cardCount,
        public array $images,
    ) {}
}
