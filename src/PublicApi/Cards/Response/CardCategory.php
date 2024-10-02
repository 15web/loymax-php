<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards\Response;

/**
 * @api
 * Информация о категории карты
 */
final readonly class CardCategory
{
    /**
     * @param positive-int $id Идентификатор
     * @param non-empty-string $title Название
     * @param non-empty-string $logicalName Логическое имя (для отображения изображения типа карты в ЛК)
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $logicalName,
    ) {}
}
