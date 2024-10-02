<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\History\Response;

/**
 * @api
 * Информации о валюте
 */
final readonly class Currency
{
    /**
     * @param int $id Внутренний идентификатор валюты
     * @param string $name Название валюты
     * @param string $code Код валюты
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $code,
    ) {}
}
