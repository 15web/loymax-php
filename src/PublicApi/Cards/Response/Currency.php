<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards\Response;

use Symfony\Component\Uid\Uuid;

/**
 * @api
 * Информации о валюте
 */
final readonly class Currency
{
    /**
     * @param positive-int $id Внутренний идентификатор валюты
     * @param non-empty-string $name Название валюты
     * @param non-empty-string $code Код валюты
     * @param Uuid $uid Внешний идентификатор валюты
     * @param Uuid|null $imageId Внешний идентификатор изображения валюты
     * @param non-empty-string|null $description Описание валюты
     * @param bool $isDeleted Статус валюты: true — архивная, false — неархивная
     * @param CurrencyNameCases $nameCases Варианты написания
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $code,
        public Uuid $uid,
        public Uuid $externalId,
        public ?Uuid $imageId,
        public ?string $description,
        public bool $isDeleted,
        public CurrencyNameCases $nameCases,
    ) {}
}
