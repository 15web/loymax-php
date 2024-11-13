<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards\Response;

use Symfony\Component\Uid\Uuid;

/**
 * @api
 * Изображение карты соответствующей категории
 */
final readonly class CardCategoryImage
{
    /**
     * @param Uuid $fileId Внешний идентификатор файла (изображение)
     * @param non-empty-string|null $description Описание изображения
     */
    public function __construct(
        public Uuid $fileId,
        public ?string $description,
    ) {}
}
