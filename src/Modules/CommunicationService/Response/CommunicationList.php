<?php

declare(strict_types=1);

namespace Studio15\Loymax\Modules\CommunicationService\Response;

use DateTimeImmutable;

/**
 * Подробная информация о персональных предложениях
 */
final readonly class CommunicationList
{
    /**
     * @param list<Communication>|null $items Список предложений
     * @param non-empty-string|null $proposalName Название персонального предложения
     * @param DateTimeImmutable|null $sentDate Дата отправки персонального предложения
     * @param DateTimeImmutable|null $validDate Дата валидности персонального предложения
     * @param string|null $state Статус персонального предложения
     */
    public function __construct(
        public ?array $items,
        public ?string $proposalName,
        public ?DateTimeImmutable $sentDate,
        public ?DateTimeImmutable $validDate,
        public ?string $state,
    ) {}
}
