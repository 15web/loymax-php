<?php

declare(strict_types=1);

namespace Studio15\Loymax\Modules\CommunicationService\Response;

/**
 * @api
 * Изображение
 */
final readonly class Image
{
    /**
     * @param non-empty-string $value Ссылка на изображение
     */
    public function __construct(
        public string $value,
    ) {}
}
