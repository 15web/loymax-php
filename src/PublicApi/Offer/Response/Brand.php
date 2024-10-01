<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Offer\Response;

use Symfony\Component\Uid\Uuid;

/**
 * Бренд
 */
final readonly class Brand
{
    /**
     * @param Uuid $id Внутренний идентификатор бренда
     * @param non-empty-string $name Название бренда
     * @param non-empty-string $description Описание бренда
     */
    public function __construct(
        public Uuid $id,
        public string $name,
        public string $description,
    ) {}
}
