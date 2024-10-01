<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

/**
 * Информация о статусной системе
 */
final readonly class StatusSystem
{
    /**
     * @param non-empty-string $name Название статусной системы
     * @param string $description Описание статусной системы
     * @param list<StatusItem> $statuses Список всех статусов статусной системы
     * @param StatusItem $currentStatus Текущий статус клиента
     * @param float $currentValue Текущее значение счетчика
     * @param float $nextStatusValue Значение счетчика для перехода на следующий статус
     */
    public function __construct(
        public string $name,
        public string $description,
        public array $statuses,
        public StatusItem $currentStatus,
        public float $currentValue,
        public float $nextStatusValue,
    ) {}
}
