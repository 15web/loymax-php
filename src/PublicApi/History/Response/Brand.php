<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\History\Response;

use Symfony\Component\Uid\Uuid;

/**
 * @api
 * Бренд
 */
final readonly class Brand
{
    /**
     * @param Uuid $uid ID бренда
     * @param non-empty-string $name Название бренда
     */
    public function __construct(
        public Uuid $uid,
        public string $name,
    ) {}
}
