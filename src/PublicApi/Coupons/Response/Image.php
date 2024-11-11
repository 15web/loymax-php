<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Coupons\Response;

/**
 * @api
 * Изображение купона
 */
final readonly class Image
{
    /**
     * @param non-empty-string $fileName Название изображения
     * @param non-negative-int $fileSize Размер изображения
     * @param non-empty-string $content Содержимое изображения
     * @param non-empty-string $mimeType Mime-тип изображения
     */
    public function __construct(
        public string $fileName,
        public int $fileSize,
        public string $content,
        public string $mimeType,
    ) {}
}
