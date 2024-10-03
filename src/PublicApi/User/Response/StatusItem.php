<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

/**
 * @api
 * Информация по отдельному статусу статусной системы
 */
final readonly class StatusItem
{
    /**
     * @param non-empty-string $name Название статуса
     * @param string|null $description Описание статуса
     * @param float|null $threshold Порог статуса
     * @param string|null $preferences Преференции статуса (первая строка)
     * @param string|null $preferencesAdditional Преференции статуса (вторая строка)
     */
    public function __construct(
        public string $name,
        public ?string $description,
        public ?float $threshold,
        public ?string $preferences,
        public ?string $preferencesAdditional,
    ) {}
}
