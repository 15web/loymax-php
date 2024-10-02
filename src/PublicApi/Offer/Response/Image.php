<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Offer\Response;

/**
 * @api
 * Изображение
 */
final readonly class Image
{
    /**
     * @param non-empty-string $fileId Внешний идентификатор файла
     */
    public function __construct(
        public string $fileId,
    ) {}
}
