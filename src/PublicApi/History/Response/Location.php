<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\History\Response;

/**
 * @api
 * Местоположение торговой точки
 */
final readonly class Location
{
    /**
     * @param positive-int $id Внутренний идентификатор местоположения
     * @param non-empty-string|null $description Описание
     */
    public function __construct(
        public int $id,
        public ?string $description,
    ) {}
}
