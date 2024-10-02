<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Offer\Response;

/**
 * @api
 * Акция
 */
final readonly class Offer
{
    /**
     * @param positive-int $id Внутренний идентификатор акции
     * @param non-empty-string $title Название акции
     * @param non-empty-string $description Описание акции
     * @param positive-int $merchantsCount Количество торговых точек, в которых проходит акция
     * @param list<Brand> $brands Список брендов
     * @param non-empty-string $begin Дата и время начала действия акции
     * @param non-empty-string|null $end Дата и время окончания действия акции
     * @param list<Image> $images Изображения
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public int $merchantsCount,
        public array $brands,
        public string $begin,
        public ?string $end,
        public array $images,
    ) {}
}
